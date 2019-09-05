<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterZuordnungsRepository;
use Cluster\Domain\ClusterZuordnungsService;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleClusterRepository;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleClusterZuordnungsRepository;
use DatenImport\Domain\ChariteFaecherAnlegenService;
use DatenImport\Domain\ChariteMCPruefungFachPersistenzService;
use DatenImport\Domain\LernzielFachRepository;
use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\Charite_Ergebnisse_CSVImportService;
use DatenImport\Infrastructure\Persistence\Filesystem\FileBasedSimpleLernzielFachRepository;
use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiInternRepository;
use Tests\Integration\Common\DbRepoTestCase;

class ChariteMcFachPersistenzServiceTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiInternRepository::class;

    public function getNeededRepos() {

        return [
            'file-based-repos' => [
                FileBasedSimpleClusterRepository::createTempFileRepo(),
                FileBasedSimpleClusterZuordnungsRepository::createTempFileRepo(),
                FileBasedSimpleLernzielFachRepository::createTempFileRepo(),
            ],
            'db-repos'         => [
                $this->currentContainer->get(ClusterRepository::class),
                $this->currentContainer->get(ClusterZuordnungsRepository::class),
                $this->currentContainer->get(LernzielFachRepository::class),
            ],
        ];
    }

    /**
     * @dataProvider getNeededRepos
     */
    public function testPersistierePruefung(
        ClusterRepository $clusterRepository,
        ClusterZuordnungsRepository $clusterZuordnungsRepository,
        LernzielFachRepository $lernzielFachRepository
    ) {
        $this->clearRepos([$clusterRepository, $clusterZuordnungsRepository]);
        (new ChariteFaecherAnlegenService($clusterRepository))->addAlleFaecherZuDB();
        LernzielFachPersistenzServiceTest::createLernzielFaecher($clusterRepository, $lernzielFachRepository);

        $csvImportService = new Charite_Ergebnisse_CSVImportService();
        $zuordnungsService = new ClusterZuordnungsService(
            $clusterZuordnungsRepository,
            $clusterRepository
        );

        $service = new ChariteMCPruefungFachPersistenzService(
            $clusterRepository,
            $zuordnungsService,
            $lernzielFachRepository,
        );

        $pruefungsId = PruefungsId::fromString("MC-WiSe2018");
        $data = $csvImportService->getData(
            __DIR__ . "/TestFileMCErgebnisse_WiSe201819_1.csv",
            ",",
            TRUE,
            AbstractCSVImportService::OUT_ENCODING,
            $pruefungsId
        );

        $service->persistiereFachZuordnung($data);

        $this->assertCount(11, $clusterZuordnungsRepository->all());

    }

    protected function clearDatabase(): void {

    }

}