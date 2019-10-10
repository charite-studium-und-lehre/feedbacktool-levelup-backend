<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use DatenImport\Domain\ChariteMCPruefungWertungPersistenzService;
use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\Charite_Ergebnisse_CSVImportService;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItemId;
use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Domain\PruefungsPeriode;
use Pruefung\Infrastructure\Persistence\Filesystem\FileBasedSimplePruefungsItemRepository;
use Studi\Domain\StudiInternRepository;
use Studi\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiInternRepository;
use StudiPruefung\Domain\StudiPruefungsRepository;
use StudiPruefung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiPruefungsRepository;
use Tests\Integration\Common\DbRepoTestCase;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\StudiPruefungsWertungRepository;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\Punktzahl;
use Wertung\Infrastructure\Persistence\Filesystem\FileBasedSimpleItemWertungsRepository;
use Wertung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiPruefungsWertungRepository;

class ChariteMcPersistenzServiceTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiInternRepository::class;

    public function getNeededRepos() {

        return [
            'file-based-repos' => [
                FileBasedSimpleStudiPruefungsRepository::createTempFileRepo(),
                FileBasedSimplePruefungsItemRepository::createTempFileRepo(),
                FileBasedSimpleStudiInternRepository::createTempFileRepo(),
                FileBasedSimpleStudiPruefungsWertungRepository::createTempFileRepo(),
                FileBasedSimpleItemWertungsRepository::createTempFileRepo(),
            ],
            'db-repos'         => [
                $this->currentContainer->get(StudiPruefungsRepository::class),
                $this->currentContainer->get(PruefungsItemRepository::class),
                $this->currentContainer->get(StudiInternRepository::class),
                $this->currentContainer->get(StudiPruefungsWertungRepository::class),
                $this->currentContainer->get(ItemWertungsRepository::class),
            ],
        ];
    }

    /**
     * @dataProvider getNeededRepos
     */
    public function testPersistierePruefung(
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        StudiInternRepository $studiInternRepository,
        StudiPruefungsWertungRepository $studiPruefungsWertungRepository,
        ItemWertungsRepository $itemWertungsRepository
    ) {
        $filename = __DIR__ . "/TestFileMCErgebnisse_WiSe201819_1.csv";
        $this->clearRepos([$studiPruefungsRepository, $pruefungsItemRepository,
                           $studiPruefungsWertungRepository, $studiInternRepository, $itemWertungsRepository]);
        $this->createTestStudis($studiInternRepository);

        $csvImportService = new Charite_Ergebnisse_CSVImportService();

        $service = new ChariteMCPruefungWertungPersistenzService(
            $studiPruefungsRepository,
            $itemWertungsRepository,
            $pruefungsItemRepository,
            $studiInternRepository,
            $studiPruefungsWertungRepository,
        );

        $data = $csvImportService->getData(
            $filename,
            ",",
            TRUE,
            AbstractCSVImportService::OUT_ENCODING,
            PruefungsPeriode::fromInt("201821")
        );

        $service->persistierePruefung($data);

        $this->assertCount(3, $studiPruefungsRepository->all());
        $this->assertTrue($studiPruefungsRepository->all()[0]
                              ->getPruefungsId()->equals(PruefungsId::fromString("MC-Sem1-201821")));

        $this->assertCount(137, $pruefungsItemRepository->all());
        $this->assertTrue($pruefungsItemRepository->all()[0]
                              ->getPruefungsId()->equals(PruefungsId::fromString("MC-Sem1-201821")));

        $this->assertCount(3, $studiPruefungsWertungRepository->all());

        $pruefungsGesamtWertung = $studiPruefungsWertungRepository->byStudiPruefungsId(
            $studiPruefungsRepository->all()[0]->getId(),
        );
        $this->assertNotNull($pruefungsGesamtWertung);
        $this->refreshEntities($pruefungsGesamtWertung);

        $this->assertTrue($pruefungsGesamtWertung->getGesamtErgebnis()->getSkala()->equals(
            PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(57)))
        );
        $this->assertTrue($pruefungsGesamtWertung->getGesamtErgebnis()->equals(
            PunktWertung::fromPunktzahlUndSkala(
                Punktzahl::fromFloat(52),
                PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(57)))
        ));

        $itemWertung = $itemWertungsRepository->byStudiPruefungsIdUndPruefungssItemId(
            $studiPruefungsRepository->all()[0]->getId(),
            PruefungsItemId::fromString("MC-Sem1-201821-22")
        );
        $this->assertTrue($itemWertung->getWertung()->equals(
            PunktWertung::fromPunktzahlUndSkala(
                Punktzahl::fromFloat(1),
                PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(1)))
        ));

    }

    protected function clearDatabase(): void {

    }

}