<?php

namespace Tests\Unit\DatenImport\Infrastructure;

use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterZuordnungsService;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleClusterRepository;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleZuordnungsService;
use Common\Domain\DDDRepository;
use DatenImport\Domain\ChariteMCPruefungFachPersistenzService;
use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\ChariteMC_Ergebnisse_CSVImportService;
use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Infrastructure\Persistence\Filesystem\FileBasedSimplePruefungsItemRepository;
use Studi\Domain\StudiInternRepository;
use Tests\Integration\Common\DbRepoTestCase;

class ChariteMcFachPersistenzServiceTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiInternRepository::class;

    public function getNeededRepos() {

        return [
            'db-repos'         => [
                $this->currentContainer->get(PruefungsItemRepository::class),
                $this->currentContainer->get(ClusterRepository::class),
                $this->currentContainer->get(ClusterZuordnungsService::class),
            ],
            'file-based-repos' => [
                FileBasedSimplePruefungsItemRepository::createTempFileRepo(),
                FileBasedSimpleClusterRepository::createTempFileRepo(),
                FileBasedSimpleZuordnungsService::createTempFileRepo(),
            ],
        ];
    }

    /**
     * @dataProvider getNeededRepos
     */
    public function testPersistierePruefung(
        PruefungsItemRepository $pruefungsItemRepository,
        ClusterRepository $clusterRepository,
        ClusterZuordnungsService $clusterZuordnungsService
    ) {
        $this->clearRepos([$pruefungsItemRepository, $clusterRepository, $clusterZuordnungsService]);

        $csvImportService = new ChariteMC_Ergebnisse_CSVImportService(
            [
                AbstractCSVImportService::INPUTFILE_OPTION => __DIR__ . "/TestFileMCErgebnisse_WiSe201819_1.csv",
                AbstractCSVImportService::DELIMITER_OPTION => ",",
            ]
        );

        $service = new ChariteMCPruefungFachPersistenzService(
            $pruefungsItemRepository,
            $clusterRepository,
            $clusterZuordnungsService,
            );

        $data = $csvImportService->getMCData();
        $service->persistiereFachZuordnung($data);

        $clusters = $clusterRepository->all();
        $this->assertCount(40, $clusters);

        $this->assertCount(140, $clusterZuordnungsService->all());

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