<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use DatenImport\Domain\ChariteStationenPruefungPersistenzService;
use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\ChariteStationenErgebnisse_CSVImportService;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItemId;
use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Domain\PruefungsRepository;
use Pruefung\Infrastructure\Persistence\Filesystem\FileBasedSimplePruefungsItemRepository;
use Pruefung\Infrastructure\Persistence\Filesystem\FileBasedSimplePruefungsRepository;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiIntern;
use Studi\Domain\StudiInternRepository;
use Studi\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiInternRepository;
use StudiPruefung\Domain\StudiPruefungsRepository;
use StudiPruefung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudienfortschrittRepository;
use StudiPruefung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiPruefungsRepository;
use Tests\Integration\Common\DbRepoTestCase;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\Skala\ProzentSkala;
use Wertung\Domain\Wertung\ProzentWertung;
use Wertung\Domain\Wertung\Prozentzahl;
use Wertung\Infrastructure\Persistence\Filesystem\FileBasedSimpleItemWertungsRepository;

class ChariteStationenPersistenzServiceTestTeil1Klinik extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiInternRepository::class;

    public function getNeededRepos() {

        return [
            'db-repos'         => [
                $this->currentContainer->get(PruefungsRepository::class),
                $this->currentContainer->get(StudiPruefungsRepository::class),
                $this->currentContainer->get(PruefungsItemRepository::class),
                $this->currentContainer->get(ItemWertungsRepository::class),
                $this->currentContainer->get(StudiInternRepository::class),
            ],
            'file-based-repos' => [
                FileBasedSimplePruefungsRepository::createTempFileRepo(),
                FileBasedSimpleStudiPruefungsRepository::createTempFileRepo(),
                FileBasedSimplePruefungsItemRepository::createTempFileRepo(),
                FileBasedSimpleItemWertungsRepository::createTempFileRepo(),
                FileBasedSimpleStudiInternRepository::createTempFileRepo(),
            ],
        ];
    }

    /**
     * @dataProvider getNeededRepos
     */
    public function testImportStudiInternPersistenz(
        PruefungsRepository $pruefungsRepository,
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        ItemWertungsRepository $itemWertungsRepository,
        StudiInternRepository $studiInternRepository
    ) {
        $this->clearRepos([$pruefungsRepository, $studiPruefungsRepository,
                           $pruefungsItemRepository, $itemWertungsRepository, $studiInternRepository]);
        $this->createTestStudis($studiInternRepository);

        $csvImportService = new ChariteStationenErgebnisse_CSVImportService();

        $service = new ChariteStationenPruefungPersistenzService(
            $pruefungsRepository,
            $studiPruefungsRepository,
            $pruefungsItemRepository,
            $itemWertungsRepository,
            $studiInternRepository
        );

        $data = $csvImportService->getData(
            __DIR__ . "/TEST_Teil1KLINIKSoSe2018.csv",
            ","
        );
        $pruefungsId = PruefungsId::fromString("Stat-20182-123");
        $service->persistierePruefung($data, $pruefungsId);

        $this->assertCount(32, $studiPruefungsRepository->all());
        $this->assertTrue($studiPruefungsRepository->all()[0]
                              ->getPruefungsId()->equals($pruefungsId));

        $this->assertCount(5, $pruefungsItemRepository->all());
        $this->assertTrue($pruefungsItemRepository->all()[0]
                              ->getPruefungsId()->equals($pruefungsId));

        $this->assertCount(64, $itemWertungsRepository->all());

        $pruefungsItem1 = $itemWertungsRepository->byStudiPruefungsIdUndPruefungssItemId(
            $studiPruefungsRepository->all()[0]->getId(),
            PruefungsItemId::fromString("Stat-20182-123--S1#N4")
        );
        $this->assertNotNull($pruefungsItem1);
        $this->refreshEntities($pruefungsItem1);
        $this->assertTrue($pruefungsItem1->getWertung()->getSkala()->equals(
            ProzentSkala::create())
        );
        $this->assertEquals(
            ProzentWertung::fromProzentzahl(Prozentzahl::fromFloatRunden(.673684210526316))
                ->getRelativeWertung(),
            $pruefungsItem1->getWertung()->getRelativeWertung()
        );
        $pruefungsItem2 = $itemWertungsRepository->byStudiPruefungsIdUndPruefungssItemId(
            $studiPruefungsRepository->all()[0]->getId(),
            PruefungsItemId::fromString("Stat-20182-123--S1#U3")
        );
        $this->assertEquals(
            ProzentWertung::fromProzentzahl(Prozentzahl::fromFloatRunden(.54))->getRelativeWertung(),
            $pruefungsItem2->getWertung()->getRelativeWertung()
        );

    }

    protected function clearDatabase(): void {

    }

}