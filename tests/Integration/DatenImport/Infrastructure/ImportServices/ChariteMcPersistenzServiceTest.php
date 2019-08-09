<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use DatenImport\Domain\ChariteMCPruefungWertungPersistenzService;
use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\ChariteMC_Ergebnisse_CSVImportService;
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
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\Punktzahl;
use Wertung\Infrastructure\Persistence\Filesystem\FileBasedSimpleItemWertungsRepository;

class ChariteMcPersistenzServiceTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiInternRepository::class;

    public function getNeededRepos() {

        return [
            'file-based-repos' => [
                FileBasedSimplePruefungsRepository::createTempFileRepo(),
                FileBasedSimpleStudiPruefungsRepository::createTempFileRepo(),
                FileBasedSimplePruefungsItemRepository::createTempFileRepo(),
                FileBasedSimpleItemWertungsRepository::createTempFileRepo(),
                FileBasedSimpleStudiInternRepository::createTempFileRepo(),
            ],
            'db-repos'         => [
                $this->currentContainer->get(PruefungsRepository::class),
                $this->currentContainer->get(StudiPruefungsRepository::class),
                $this->currentContainer->get(PruefungsItemRepository::class),
                $this->currentContainer->get(ItemWertungsRepository::class),
                $this->currentContainer->get(StudiInternRepository::class),
            ],
        ];
    }

    /**
     * @dataProvider getNeededRepos
     */
    public function testPersistierePruefung(
        PruefungsRepository $pruefungsRepository,
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        ItemWertungsRepository $itemWertungsRepository,
        StudiInternRepository $studiInternRepository
    ) {
        $filename = __DIR__ . "/TestFileMCErgebnisse_WiSe201819_1.csv";
        $this->clearRepos([$pruefungsRepository, $studiPruefungsRepository,
                           $pruefungsItemRepository, $itemWertungsRepository, $studiInternRepository]);
        $this->createTestStudis($studiInternRepository);

        $csvImportService = new ChariteMC_Ergebnisse_CSVImportService(
            [
                AbstractCSVImportService::INPUTFILE_OPTION => $filename,
                AbstractCSVImportService::DELIMITER_OPTION => ",",
            ]
        );

        $pruefungsId = $csvImportService->getPruefungsId();

        $service = new ChariteMCPruefungWertungPersistenzService(
            $pruefungsId,
            $pruefungsRepository,
            $studiPruefungsRepository,
            $pruefungsItemRepository,
            $itemWertungsRepository,
            $studiInternRepository
        );


        $data = $csvImportService->getData();
        $service->persistierePruefung($data);

        $this->assertCount(3, $studiPruefungsRepository->all());
        $this->assertTrue($studiPruefungsRepository->all()[0]
                              ->getPruefungsId()->equals($pruefungsId));

        $this->assertCount(200, $pruefungsItemRepository->all());
        $this->assertTrue($pruefungsItemRepository->all()[0]
                              ->getPruefungsId()->equals($pruefungsId));

        $this->assertCount(200, $itemWertungsRepository->all());

        $itemWertung1 = $itemWertungsRepository->byStudiPruefungsIdUndPruefungssItemId(
            $studiPruefungsRepository->all()[0]->getId(),
            PruefungsItemId::fromString("MC-WiSe2018-1-3")
        );
        $this->assertNotNull($itemWertung1);
        $this->refreshEntities($itemWertung1);
        $this->assertTrue($itemWertung1->getWertung()->getSkala()->equals(
            PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(1)))
        );
        $this->assertTrue($itemWertung1->getWertung()->equals(
            PunktWertung::fromPunktzahlUndSkala(
                Punktzahl::fromFloat(0),
                PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(1)))
        ));

        $itemWertung2 = $itemWertungsRepository->byStudiPruefungsIdUndPruefungssItemId(
            $studiPruefungsRepository->all()[0]->getId(),
            PruefungsItemId::fromString("MC-WiSe2018-1-1")
        );
        $this->assertTrue($itemWertung2->getWertung()->equals(
            PunktWertung::fromPunktzahlUndSkala(
                Punktzahl::fromFloat(1),
                PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(1)))
        ));

    }

    protected function clearDatabase(): void {

    }



}