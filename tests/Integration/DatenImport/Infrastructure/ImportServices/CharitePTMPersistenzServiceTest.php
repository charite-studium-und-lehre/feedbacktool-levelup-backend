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
use Pruefung\Domain\PruefungsRepository;
use Pruefung\Infrastructure\Persistence\Filesystem\FileBasedSimplePruefungsItemRepository;
use Pruefung\Infrastructure\Persistence\Filesystem\FileBasedSimplePruefungsRepository;
use Studi\Domain\StudiInternRepository;
use Studi\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiInternRepository;
use StudiPruefung\Domain\StudiPruefungsRepository;
use StudiPruefung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiMeilensteinRepository;
use Tests\Integration\Common\DbRepoTestCase;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Infrastructure\Persistence\Filesystem\FileBasedSimpleItemWertungsRepository;

class CharitePTMPersistenzServiceTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiInternRepository::class;

    public function getNeededRepos() {

        return [
            'file-based-repos' => [
                FileBasedSimplePruefungsRepository::createTempFileRepo(),
                FileBasedSimpleStudiMeilensteinRepository::createTempFileRepo(),
                FileBasedSimpleItemWertungsRepository::createTempFileRepo(),
                FileBasedSimplePruefungsItemRepository::createTempFileRepo(),
                FileBasedSimpleStudiInternRepository::createTempFileRepo(),
                FileBasedSimpleClusterRepository::createTempFileRepo(),
                FileBasedSimpleClusterZuordnungsRepository::createTempFileRepo(),
            ],
            'db-repos'         => [
                $this->currentContainer->get(PruefungsRepository::class),
                $this->currentContainer->get(StudiPruefungsRepository::class),
                $this->currentContainer->get(ItemWertungsRepository::class),
                $this->currentContainer->get(PruefungsItemRepository::class),
                $this->currentContainer->get(StudiInternRepository::class),
                $this->currentContainer->get(ClusterRepository::class),
                $this->currentContainer->get(ClusterZuordnungsRepository::class),
            ],
        ];
    }

    /**
     * @dataProvider getNeededRepos
     */
    public function testPersistierePruefung(
        PruefungsRepository $pruefungsRepository,
        StudiPruefungsRepository $studiPruefungsRepository,
        ItemWertungsRepository $itemWertungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        StudiInternRepository $studiInternRepository,
        ClusterRepository $clusterRepository,
        ClusterZuordnungsRepository $clusterZuordnungsRepository
    ) {
        $this->clearRepos([$clusterRepository, $studiPruefungsRepository, $pruefungsItemRepository,
                           $itemWertungsRepository, $pruefungsItemRepository, $studiInternRepository,
                           $clusterRepository, $clusterZuordnungsRepository]);

        (new ChariteFaecherAnlegenService($clusterRepository))->addAlleFaecherZuDB();
        $this->createTestStudis($studiInternRepository);

        $csvImportService = new CharitePTMCSVImportService();

        $pruefungsId = PruefungsId::fromString("PT38");

        $service = new CharitePTMPersistenzService(
            $pruefungsId,
            $pruefungsRepository,
            $studiPruefungsRepository,
            $itemWertungsRepository,
            $pruefungsItemRepository,
            $studiInternRepository,
            $clusterRepository,
            $clusterZuordnungsRepository
        );

        $data = $csvImportService->getData(
            __DIR__ . "/TESTEinzeldaten Berlin PT38(gesamt).csv",
            ";"
        );

        $service->persistierePruefung($data);

        //        $clusters = $clusterRepository->all();
        //        $this->assertCount(40, $clusters);
        //
        //        $this->assertTrue($clusters[0]->getTitel()->equals(ClusterTitel::fromString("Kinderheilkunde")));
        //
        $this->assertCount(41, $pruefungsItemRepository->all());
        $this->assertCount(27, $clusterZuordnungsRepository->all());

    }

    protected function clearDatabase(): void {

    }

}