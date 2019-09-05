<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterZuordnungsRepository;
use Cluster\Domain\ClusterZuordnungsService;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleClusterRepository;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleClusterZuordnungsRepository;
use DatenImport\Domain\ChariteMCPruefungLernzielModulPersistenzService;
use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\ChariteLernzielModulImportCSVService;
use DatenImport\Infrastructure\Persistence\Charite_Ergebnisse_CSVImportService;
use Pruefung\Domain\PruefungsId;
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
                FileBasedSimpleClusterZuordnungsRepository::createTempFileRepo(),
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

        $csvMcImportService = new Charite_Ergebnisse_CSVImportService();
        $lzModulImportService = new ChariteLernzielModulImportCSVService();

        $lzModulData = $lzModulImportService->getLernzielZuModulData(
            __DIR__ . "/Lernziel-Module.csv", ";", TRUE
        );
        $pruefungsId = PruefungsId::fromString("MC-WiSe2018");
        $mcData = $csvMcImportService->getData(
            __DIR__ . "/TestFileMCErgebnisse_WiSe201819_1.csv",
            ",",
            TRUE,
            AbstractCSVImportService::OUT_ENCODING,
            $pruefungsId
        );

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

}