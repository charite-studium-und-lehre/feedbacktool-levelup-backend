<?php

namespace Tests\Unit\DatenImport\Infrastructure;

use DatenImport\Domain\ChariteMCPruefungWertungPersistenzService;
use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\ChariteMC_Ergebnisse_CSVImportService;
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
use StudiPruefung\Domain\StudiPruefungsId;
use StudiPruefung\Domain\StudiPruefungsRepository;
use StudiPruefung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiPruefungsRepository;
use Tests\Integration\Common\DbRepoTestCase;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\Punktzahl;
use Wertung\Infrastructure\Persistence\Filesystem\FileBasedSimpleItemWertungsRepository;

class ChariteMcPersistenzServiceTest extends DbRepoTestCase
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

        $csvImportService = new ChariteMC_Ergebnisse_CSVImportService(
            [
                AbstractCSVImportService::INPUTFILE_OPTION => __DIR__ . "/TestFileMCErgebnisse_WiSe201819_1.csv",
                AbstractCSVImportService::DELIMITER_OPTION => ",",
            ]
        );

        $service = new ChariteMCPruefungWertungPersistenzService(
            PruefungsId::fromInt(1234),
            $csvImportService,
            $pruefungsRepository,
            $studiPruefungsRepository,
            $pruefungsItemRepository,
            $itemWertungsRepository,
            $studiInternRepository
        );

        $service->persistierePruefung();

        $this->assertCount(3, $studiPruefungsRepository->all());
        $this->assertTrue($studiPruefungsRepository->all()[0]
                              ->getPruefungsId()->equals(PruefungsId::fromInt(1234)));

        $this->assertCount(200, $pruefungsItemRepository->all());
        $this->assertTrue($pruefungsItemRepository->all()[0]
                              ->getPruefungsId()->equals(PruefungsId::fromInt(1234)));

        $this->assertCount(200, $itemWertungsRepository->all());

        $pruefungsItem1 = $itemWertungsRepository->byStudiPruefungsIdUndPruefungssItemId(
            $studiPruefungsRepository->all()[0]->getId(),
            PruefungsItemId::fromInt(3)
        );
        $this->assertNotNull($pruefungsItem1);
        $this->refreshEntities($pruefungsItem1);
        $this->assertTrue($pruefungsItem1->getWertung()->getSkala()->equals(
            PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(1)))
        );
        $this->assertTrue($pruefungsItem1->getWertung()->equals(
            PunktWertung::fromPunktzahlUndSkala(
                Punktzahl::fromFloat(0),
                PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(1)))
        ));

        $pruefungsItem2 = $itemWertungsRepository->byStudiPruefungsIdUndPruefungssItemId(
            $studiPruefungsRepository->all()[0]->getId(),
            PruefungsItemId::fromInt(5)
        );
        $this->assertTrue($pruefungsItem2->getWertung()->equals(
            PunktWertung::fromPunktzahlUndSkala(
                Punktzahl::fromFloat(1),
                PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(1)))
        ));

    }

    protected function clearDatabase(): void {

    }

    private function createTestStudis(StudiInternRepository $studiInternRepo): void {

        foreach ($studiInternRepo->all() as $studiIntern) {
            $studiInternRepo->delete($studiIntern);
            $studiInternRepo->flush();
        }
        $studiInternRepo->add(StudiIntern::fromMatrikelUndStudiHash(
            Matrikelnummer::fromInt("222222"),
            StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$SjNFNWJPNXVFTkVoaEEwcQ$xrpCKHbfjfjRLrn0K1keYfk6SCFlGQfWuT7edgpaO8E')
        ));
        $studiInternRepo->add(StudiIntern::fromMatrikelUndStudiHash(
            Matrikelnummer::fromInt("444444"),
            StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$LkhXWG5HRS9hWm1kWWx0VA$qSA8yS4/Zdsm0zeWajL3uw3188zkk/HCPZic0KlweCs')
        ));
        $studiInternRepo->add(StudiIntern::fromMatrikelUndStudiHash(
            Matrikelnummer::fromInt("555555"),
            StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$anh4WFZZc3VDdExCdEMzdg$Zfy1+698erxOxiqG0RhUqiZ7uHt59nrR9llJMlsJXOY')
        ));
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