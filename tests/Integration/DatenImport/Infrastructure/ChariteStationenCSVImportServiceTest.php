<?php

namespace Tests\Unit\DatenImport\Infrastructure;

use Cluster\Domain\ClusterTitel;
use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\ChariteMC_Ergebnisse_CSVImportService;
use DatenImport\Infrastructure\Persistence\ChariteStationenErgebnisse_CSVImportService;
use PHPUnit\Framework\TestCase;
use Pruefung\Domain\PruefungsItemId;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Wertung\Domain\Wertung\Punktzahl;

class ChariteStationenCSVImportServiceTest extends TestCase
{

    public function testTeil1Klinik() {

        $csvImportService =
            new ChariteStationenErgebnisse_CSVImportService(
                [
                    AbstractCSVImportService::INPUTFILE_OPTION => __DIR__ . "/TEST_Teil1KLINIkSoSe2018.csv",
                    AbstractCSVImportService::DELIMITER_OPTION => ",",
                ]
            );
        $data = $csvImportService->getData();

        $this->assertCount(32, $data);

        $this->assertEquals("111111", $data[0]["matrikelnummer"]);
        $this->assertIsArray($data[0]["ergebnisse"]);
        $this->assertCount(2, $data[0]["ergebnisse"]);
        $this->assertEquals("S1#N4", array_keys($data[0]["ergebnisse"])[0]);
        $this->assertEquals("S1#U3", array_keys($data[0]["ergebnisse"])[1]);
        $this->assertEquals(0.673684210526316, $data[0]["ergebnisse"]["S1#N4"]);
        $this->assertEquals(0.54, $data[0]["ergebnisse"]["S1#U3"]);


        $this->assertEquals("111142", $data[31]["matrikelnummer"]);
        $this->assertIsArray($data[31]["ergebnisse"]);
        $this->assertCount(2, $data[31]["ergebnisse"]);
        $this->assertEquals("S1#N4", array_keys($data[31]["ergebnisse"])[0]);
        $this->assertEquals("S1#U2", array_keys($data[31]["ergebnisse"])[1]);
        $this->assertEquals(0.873684210526316, $data[31]["ergebnisse"]["S1#N4"]);
        $this->assertEquals(0.926315789473684, $data[31]["ergebnisse"]["S1#U2"]);

    }

    public function testTeil1VorKlinik() {
        $csvImportService =
            new ChariteStationenErgebnisse_CSVImportService(
                [
                    AbstractCSVImportService::INPUTFILE_OPTION => __DIR__ . "/TEST_Teil1VK_SoSe2018HAUPT.csv",
                    AbstractCSVImportService::DELIMITER_OPTION => ",",
                ]
            );
        $data = $csvImportService->getData();

        $this->assertCount(26, $data);

        $this->assertEquals("111111", $data[1]["matrikelnummer"]);
        $this->assertIsArray($data[1]["ergebnisse"]);
        $this->assertCount(2, $data[1]["ergebnisse"]);
        $this->assertEquals("Skala1_erg", array_keys($data[1]["ergebnisse"])[0]);
        $this->assertEquals("Skala2_erg", array_keys($data[1]["ergebnisse"])[1]);
        $this->assertEquals(96.6666666666667, $data[1]["ergebnisse"]["Skala1_erg"]);
        $this->assertEquals(100, $data[1]["ergebnisse"]["Skala2_erg"]);
        $this->assertEquals("Anatomie", $data[1]["fach"]);
        $this->assertEquals("03.08.2018", $data[1]["datum"]->format("d.m.Y"));
        $this->assertEquals("1292", $data[1]["pruefungsCode"]);
    }

    public function testTeil2() {
        $csvImportService =
            new ChariteStationenErgebnisse_CSVImportService(
                [
                    AbstractCSVImportService::INPUTFILE_OPTION => __DIR__ . "/TEST_Teil2SoSe2018HAUPT.csv",
                    AbstractCSVImportService::DELIMITER_OPTION => ",",
                ]
            );
        $data = $csvImportService->getData();

        $this->assertCount(20, $data);

        $this->assertEquals("111111", $data[1]["matrikelnummer"]);
        $this->assertIsArray($data[1]["ergebnisse"]);
        $this->assertCount(2, $data[1]["ergebnisse"]);
        $this->assertEquals("Skala1_erg", array_keys($data[1]["ergebnisse"])[0]);
        $this->assertEquals("Skala2_erg", array_keys($data[1]["ergebnisse"])[1]);
        $this->assertEquals(50, $data[1]["ergebnisse"]["Skala1_erg"]);
        $this->assertEquals(50, $data[1]["ergebnisse"]["Skala2_erg"]);
        $this->assertEquals("Physiologie 2", $data[1]["fach"]);
        $this->assertEquals("08.09.2018", $data[1]["datum"]->format("d.m.Y"));
        $this->assertEquals("1492", $data[1]["pruefungsCode"]);
    }

    public function testTeil3() {
        $csvImportService =
            new ChariteStationenErgebnisse_CSVImportService(
                [
                    AbstractCSVImportService::INPUTFILE_OPTION => __DIR__ . "/TEST_Teil3SoSe2018HAUPT.csv",
                    AbstractCSVImportService::DELIMITER_OPTION => ",",
                ]
            );
        $data = $csvImportService->getData();

        $this->assertCount(176, $data);

        $this->assertEquals("111112", $data[1]["matrikelnummer"]);
        $this->assertIsArray($data[1]["ergebnisse"]);
        $this->assertCount(4, $data[1]["ergebnisse"]);
        $this->assertEquals("00#03", array_keys($data[1]["ergebnisse"])[0]);
        $this->assertEquals("15#03", array_keys($data[1]["ergebnisse"])[3]);
        $this->assertEquals(0.475, $data[1]["ergebnisse"]["00#03"]);
        $this->assertEquals(0.5375, $data[1]["ergebnisse"]["15#03"]);
        $this->assertTrue(empty($data[1]["fach"]));
        $this->assertTrue(empty($data[1]["datum"]));
        $this->assertTrue(empty($data[1]["pruefungsCode"]));
    }
}