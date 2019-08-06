<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\ChariteStudiStammdatenHIS_CSVImportService;
use PHPUnit\Framework\TestCase;
use Studi\Domain\Geburtsdatum;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Studi\Domain\Nachname;
use Studi\Domain\StudiData;
use Studi\Domain\Vorname;

class StudiStammdatenCSVImportServiceTest extends TestCase
{

    public function testGetCSVData() {

        $csvImportService =
            new ChariteStudiStammdatenHIS_CSVImportService(
                [
                    AbstractCSVImportService::FROM_ENCODING_OPTION => "ISO-8859-15",
                    AbstractCSVImportService::INPUTFILE_OPTION => __DIR__ . "/TestFileStudisStammdaten.csv",
                    AbstractCSVImportService::DELIMITER_OPTION => ";",
                    AbstractCSVImportService::DELIMITER_OPTION => ";",
                ]
            );
        $studiDataObjects = $csvImportService->getStudiData();
        $this->assertCount(16, $studiDataObjects);

        $this->assertTrue($studiDataObjects[0]->equals(
            StudiData::fromValues(
                Matrikelnummer::fromInt(221231),
                Vorname::fromString("Marika"),
                Nachname::fromString("Heißler"),
                Geburtsdatum::fromStringDeutschMinus("02-03-1984")
            )
        ));

        $this->assertTrue($studiDataObjects[15]->equals(
            StudiData::fromValues(
                Matrikelnummer::fromInt(211257),
                Vorname::fromString("Lara Sophie Katharina"),
                Nachname::fromString("von der Stääts-Lüdenscheid"),
                Geburtsdatum::fromStringDeutschMinus("10-12-1991")
            )
        ));
    }
}