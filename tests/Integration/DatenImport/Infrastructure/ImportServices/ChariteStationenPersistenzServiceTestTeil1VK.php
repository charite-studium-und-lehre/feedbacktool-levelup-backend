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
use StudiPruefung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiPruefungsRepository;
use Tests\Integration\Common\DbRepoTestCase;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\Skala\ProzentSkala;
use Wertung\Domain\Wertung\ProzentWertung;
use Wertung\Domain\Wertung\Prozentzahl;
use Wertung\Infrastructure\Persistence\Filesystem\FileBasedSimpleItemWertungsRepository;

class ChariteStationenPersistenzServiceTestTeil1VK extends DbRepoTestCase
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

        $csvImportService = new ChariteStationenErgebnisse_CSVImportService(
            [
                AbstractCSVImportService::INPUTFILE_OPTION => __DIR__ . "/TEST_Teil1VK_SoSe2018HAUPT.csv",
                AbstractCSVImportService::DELIMITER_OPTION => ",",
            ]
        );

        $service = new ChariteStationenPruefungPersistenzService(
            PruefungsId::fromString(1234),
            $pruefungsRepository,
            $studiPruefungsRepository,
            $pruefungsItemRepository,
            $itemWertungsRepository,
            $studiInternRepository
        );

        $data = $csvImportService->getData();
        $service->persistierePruefung($data);

        $this->assertCount(13, $studiPruefungsRepository->all());
        $this->assertTrue($studiPruefungsRepository->all()[0]
                              ->getPruefungsId()->equals(PruefungsId::fromString(1234)));

        $this->assertCount(12, $pruefungsItemRepository->all());
        $this->assertTrue($pruefungsItemRepository->all()[0]
                              ->getPruefungsId()->equals(PruefungsId::fromString(1234)));

        $this->assertCount(52, $itemWertungsRepository->all());

        $pruefungsItem1 = $itemWertungsRepository->byStudiPruefungsIdUndPruefungssItemId(
            $studiPruefungsRepository->all()[0]->getId(),
            PruefungsItemId::fromString(925197)
        );
        $this->assertNotNull($pruefungsItem1);
        $this->refreshEntities($pruefungsItem1);
        $this->assertTrue($pruefungsItem1->getWertung()->getSkala()->equals(
            ProzentSkala::create())
        );
        $this->assertEquals(
            ProzentWertung::fromProzentzahl(Prozentzahl::fromFloat(.9))->getRelativeWertung(),
            $pruefungsItem1->getWertung()->getRelativeWertung()
        );
        $pruefungsItem2 = $itemWertungsRepository->byStudiPruefungsIdUndPruefungssItemId(
            $studiPruefungsRepository->all()[0]->getId(),
            PruefungsItemId::fromString(631774)
        );
        $this->assertEquals(
            ProzentWertung::fromProzentzahl(Prozentzahl::fromFloatRunden(.966666666666667))->getRelativeWertung(),
            $pruefungsItem2->getWertung()->getRelativeWertung()
        );

    }

    protected function clearDatabase(): void {

    }

    private function createTestStudis(StudiInternRepository $studiInternRepo): void {

        foreach ($studiInternRepo->all() as $studiIntern) {
            $studiInternRepo->delete($studiIntern);
            $studiInternRepo->flush();
        }
        foreach (range(111111, 111234) as $matrikelnummer) {
            $studiInternRepo->add(StudiIntern::fromMatrikelUndStudiHash(
                Matrikelnummer::fromInt($matrikelnummer),
                StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$SjNFNWJPNXVFTkVoaEEwcQ$xrpCKHbfjfjRLrn0K1keYfk6SCFlGQfWuT7ed'
                                      . $matrikelnummer)
            ));

        }
        $studiInternRepo->flush();

    }

    private function clearRepos($repositories): void {
        foreach ($repositories as $repo) {
            foreach ($repo->all() as $object) {
                $repo->delete($object);
            }
        }
        $repo->flush();
    }

}