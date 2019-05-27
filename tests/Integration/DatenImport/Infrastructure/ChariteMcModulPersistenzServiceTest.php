<?php

namespace Tests\Unit\DatenImport\Infrastructure;

use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterZuordnungsRepository;
use Cluster\Domain\ClusterZuordnungsService;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleClusterRepository;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleZuordnungsRepository;
use Common\Domain\DDDRepository;
use DatenImport\Domain\ChariteMCPruefungLernzielModulPersistenzService;
use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\ChariteLernzielModulImportCSVService;
use DatenImport\Infrastructure\Persistence\ChariteMC_Ergebnisse_CSVImportService;
use Studi\Domain\StudiInternRepository;
use Tests\Integration\Common\DbRepoTestCase;

class ChariteMcModulPersistenzServiceTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiInternRepository::class;

    public function getNeededRepos() {

        return [
            'db-repos'         => [
                $this->currentContainer->get(ClusterRepository::class),
                $this->currentContainer->get(ClusterZuordnungsRepository::class),
            ],
            'file-based-repos' => [
                FileBasedSimpleClusterRepository::createTempFileRepo(),
                FileBasedSimpleZuordnungsRepository::createTempFileRepo(),
            ],
        ];
    }

    /**
     * @dataProvider getNeededRepos
     */
    public function testPersistierePruefung(
        ClusterRepository $clusterRepository,
        ClusterZuordnungsRepository $clusterZuordnungsRepository
    ) {
        $this->clearRepos([$clusterRepository, $clusterZuordnungsRepository]);

        $csvMcImportService = new ChariteMC_Ergebnisse_CSVImportService(
            [
                AbstractCSVImportService::INPUTFILE_OPTION => __DIR__ . "/TestFileMCErgebnisse_WiSe201819_1.csv",
                AbstractCSVImportService::DELIMITER_OPTION => ",",
            ]
        );
        $lzModulImportService = new ChariteLernzielModulImportCSVService(
            [
                AbstractCSVImportService::INPUTFILE_OPTION => __DIR__ . "/Lernziel-Module.csv",
                AbstractCSVImportService::DELIMITER_OPTION => ";",
            ]
        );

        $lzModulData = $lzModulImportService->getLernzielZuModulData();
        $mcData = $csvMcImportService->getData();

        $zuordnungsService = new ClusterZuordnungsService(
            $clusterZuordnungsRepository,
            $clusterRepository
        );
        $service = new ChariteMCPruefungLernzielModulPersistenzService(
            $clusterRepository,
            $zuordnungsService,
            );

        $service->persistiereMcModulZuordnung($mcData, $lzModulData);

        $clusters = $clusterRepository->all();
        $this->assertCount(6, $clusters);

        $this->assertCount(140, $clusterZuordnungsRepository->all());

    }

    protected function clearDatabase(): void {

    }

    private function clearRepos($repositories): void {
        foreach ($repositories as $repo) {
            /** @var DDDRepository $repo */
            foreach ($repo->all() as $object) {
                $repo->delete($object);
            }
        }
        $repo->flush();
    }

}