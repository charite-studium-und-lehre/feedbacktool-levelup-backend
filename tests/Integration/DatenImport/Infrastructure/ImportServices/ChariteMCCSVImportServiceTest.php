<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\Charite_Ergebnisse_CSVImportService;
use PHPUnit\Framework\TestCase;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItemId;
use Pruefung\Domain\PruefungsPeriode;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Wertung\Domain\Wertung\Punktzahl;

class ChariteMCCSVImportServiceTest extends TestCase
{
    public function testGetCSVData() {

        $csvImportService = new Charite_Ergebnisse_CSVImportService();
        $pruefungsId = PruefungsId::fromString("MC-WiSe2018");
        $mcData = $csvImportService->getData(
            __DIR__ . "/TestFileMCErgebnisse_WiSe201819_1.csv",
            ",",
            TRUE,
            AbstractCSVImportService::OUT_ENCODING,
            PruefungsPeriode::fromInt(201811)
        );
        $this->assertCount(194, $mcData);

        $this->assertTrue($mcData[0][0]->equals(Matrikelnummer::fromInt(222222),));
        $this->assertTrue($mcData[0][1]->equals(Punktzahl::fromFloat(1),));
        $this->assertTrue($mcData[0][2]->equals(PruefungsId::fromString("MC-Sem1-201811"),));
        $this->assertTrue($mcData[0][3]->equals(PruefungsItemId::fromString("MC-Sem1-201811-22")));

        $this->assertTrue($mcData[64][0]->equals(Matrikelnummer::fromInt(444444),));
        $this->assertTrue($mcData[64][1]->equals(Punktzahl::fromFloat(0),));
        $this->assertTrue($mcData[64][2]->equals(PruefungsId::fromString("MC-Sem2-201811"),));
        $this->assertTrue($mcData[64][3]->equals(PruefungsItemId::fromString("MC-Sem2-201811-790")));

    }
}