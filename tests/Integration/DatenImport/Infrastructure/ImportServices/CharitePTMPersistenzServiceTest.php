<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterZuordnungsRepository;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleClusterRepository;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleClusterZuordnungsRepository;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleLernzielFachRepository;
use DatenImport\Domain\ChariteFaecherAnlegenService;
use DatenImport\Domain\CharitePTMPersistenzService;
use DatenImport\Infrastructure\Persistence\CharitePTMCSVImportService;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Infrastructure\Persistence\Filesystem\FileBasedSimplePruefungsItemRepository;
use Studi\Domain\StudiInternRepository;
use Studi\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiInternRepository;
use StudiPruefung\Domain\StudiPruefungsRepository;
use StudiPruefung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudienfortschrittRepository;
use StudiPruefung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiPruefungsRepository;
use Tests\Integration\Common\DbRepoTestCase;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\StudiPruefungsWertungRepository;
use Wertung\Infrastructure\Persistence\Filesystem\FileBasedSimpleItemWertungsRepository;
use Wertung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiPruefungsWertungRepository;

class CharitePTMPersistenzServiceTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiInternRepository::class;

    public function getNeededRepos() {

        return [
            'file-based-repos' => [
                FileBasedSimpleStudiPruefungsRepository::createTempFileRepo(),
                FileBasedSimpleItemWertungsRepository::createTempFileRepo(),
                FileBasedSimplePruefungsItemRepository::createTempFileRepo(),
                FileBasedSimpleStudiInternRepository::createTempFileRepo(),
                FileBasedSimpleClusterRepository::createTempFileRepo(),
                FileBasedSimpleClusterZuordnungsRepository::createTempFileRepo(),
                FileBasedSimpleStudiPruefungsWertungRepository::createTempFileRepo(),
            ],
            'db-repos'         => [
                $this->currentContainer->get(StudiPruefungsRepository::class),
                $this->currentContainer->get(ItemWertungsRepository::class),
                $this->currentContainer->get(PruefungsItemRepository::class),
                $this->currentContainer->get(StudiInternRepository::class),
                $this->currentContainer->get(ClusterRepository::class),
                $this->currentContainer->get(ClusterZuordnungsRepository::class),
                $this->currentContainer->get(StudiPruefungsWertungRepository::class),
            ],
        ];
    }

    /**
     * @dataProvider getNeededRepos
     */
    public function testPersistierePruefung(
        StudiPruefungsRepository $studiPruefungsRepository,
        ItemWertungsRepository $itemWertungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        StudiInternRepository $studiInternRepository,
        ClusterRepository $clusterRepository,
        ClusterZuordnungsRepository $clusterZuordnungsRepository,
        StudiPruefungsWertungRepository $studiPruefungsWertungRepository
    ) {
        $this->clearRepos([$clusterRepository, $studiPruefungsRepository, $pruefungsItemRepository,
                           $itemWertungsRepository, $pruefungsItemRepository, $studiInternRepository,
                           $clusterRepository, $clusterZuordnungsRepository]);

        (new ChariteFaecherAnlegenService($clusterRepository))->addAlleFaecherZuDB();
        $this->createTestStudis($studiInternRepository);

        $csvImportService = new CharitePTMCSVImportService();

        $pruefungsId = PruefungsId::fromString("PT38");

        $service = new CharitePTMPersistenzService(
            $studiPruefungsRepository,
            $itemWertungsRepository,
            $pruefungsItemRepository,
            $studiInternRepository,
            $clusterRepository,
            $clusterZuordnungsRepository,
            $studiPruefungsWertungRepository
        );

        $data = $csvImportService->getData(
            __DIR__ . "/TESTEinzeldaten Berlin PT38(gesamt).csv",
            ";"
        );

        $service->persistierePruefung($data, $pruefungsId);

        $this->assertCount(27, $pruefungsItemRepository->all());
        $this->assertCount(27, $clusterZuordnungsRepository->all());

    }

    protected function clearDatabase(): void {

    }

}