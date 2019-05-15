<?php

namespace Tests\Unit\DatenImport\Infrastructure;

use DatenImport\Infrastructure\Persistence\StudiStammdatenHIS_CSVImportService;
use PHPUnit\Framework\TestCase;
use Studi\Domain\Geburtsdatum;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Studi\Domain\Nachname;
use Studi\Domain\StudiData;
use Studi\Domain\Vorname;
use Studi\Infrastructure\Service\StudiHashCreator_Argon2I;

class StudiStammdatenCSVImportServiceTest extends TestCase
{

    public function testGetCSVData() {

        $studiHashCreator = new StudiHashCreator_Argon2I();
        $csvImportService = new StudiStammdatenHIS_CSVImportService($studiHashCreator);
        $studiDataObjects = $csvImportService->getStudiData(
            ["inputFile" => __DIR__ . "/TestFileStudisStammdaten.csv"]
        );
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