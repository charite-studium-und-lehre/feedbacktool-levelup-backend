<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\Charite_Ergebnisse_CSVImportService;
use PHPUnit\Framework\TestCase;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItemId;
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
            $pruefungsId
        );

        $this->assertCount(200, $mcData);

        $this->assertTrue($mcData[0][0]->equals(Matrikelnummer::fromInt(222222),));
        $this->assertTrue($mcData[0][1]->equals(Punktzahl::fromFloat(1),));
        $this->assertTrue($mcData[0][2]->equals(PruefungsItemId::fromString("MC-WiSe2018-1"),));
        $this->assertNull($mcData[0][3]);

        $this->assertTrue($mcData[20][0]->equals(Matrikelnummer::fromInt(444444),));
        $this->assertTrue($mcData[20][1]->equals(Punktzahl::fromFloat(1),));
        $this->assertTrue($mcData[20][2]->equals(PruefungsItemId::fromString("MC-WiSe2018-15046"),));
        $this->assertEquals($mcData[20][3], 20007);

    }
}