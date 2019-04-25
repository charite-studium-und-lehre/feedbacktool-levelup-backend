<?php

namespace Tests\Unit\DatenImport\Infrastructure;

use DatenImport\Infrastructure\Persistence\StudiStammdatenCSVImportService;
use PHPUnit\Framework\TestCase;
use Studi\Domain\Geburtsdatum;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Studi\Domain\Nachname;
use Studi\Domain\Vorname;
use Studi\Infrastructure\Service\StudiHashCreator_Argon2I;

class PTMCSVImportServiceTest extends TestCase
{

    public function testGetCSVData() {

        $studiHashCreator = new StudiHashCreator_Argon2I();
        $csvImportService = new StudiStammdatenCSVImportService($studiHashCreator);
        $dataArray = $csvImportService->getStudiObjects(__DIR__ . "/TestFileStudisStammdaten.csv");
        $this->assertCount(16, $dataArray);

        $this->assertTrue($studiHashCreator->isCorrectStudiHash(
            $dataArray[0],
            Matrikelnummer::fromInt(221231),
            Vorname::fromString("Marika"),
            Nachname::fromString("Heißler"),
            Geburtsdatum::fromStringDeutschMinus("02-03-1984")
        ));

        $this->assertFalse($studiHashCreator->isCorrectStudiHash(
            $dataArray[0],
            Matrikelnummer::fromInt(221231),
            Vorname::fromString("Marika"),
            Nachname::fromString("Heisler"),
            Geburtsdatum::fromStringDeutschMinus("02-03-1984")
        ));

        $this->assertTrue($studiHashCreator->isCorrectStudiHash(
            $dataArray[15],
            Matrikelnummer::fromInt(211257),
            Vorname::fromString("Lara Sophie Katharina"),
            Nachname::fromString("von der Stääts-Lüdenscheid"),
            Geburtsdatum::fromStringDeutschMinus("10-12-1991")
        ));

    }
}