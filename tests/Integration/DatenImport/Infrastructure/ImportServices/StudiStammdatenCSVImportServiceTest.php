<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use Common\Domain\User\Nachname;
use Common\Domain\User\Vorname;
use DatenImport\Infrastructure\Persistence\ChariteStudiStammdatenHIS_CSVImportService;
use PHPUnit\Framework\TestCase;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Studi\Domain\StudiData;

class StudiStammdatenCSVImportServiceTest extends TestCase
{
    public function testGetCSVData() {

        $csvImportService = new ChariteStudiStammdatenHIS_CSVImportService();
        $studiDataObjects = $csvImportService->getStudiData(
            __DIR__ . "/TestFileStudisStammdaten.csv",
            ",",
            TRUE,
            "UTF-8"
        );
        $this->assertCount(16, $studiDataObjects);
        $dataLine = [
            "mtknr"        => "221231",
            "vorname"      => "Marika",
            "nachname"     => "Heißler",
            "gebdat"       => "02-03-1984",
            "hausarb_note" => "",
            "hausarb_best" => "0",
            "erste_hilfe"  => "1",
            "pflege_prakt" => "1",
            "fam_reife"    => "1",
            "m1_eq"        => "0",
            "m2_vor"       => "0",
            "stat_prfg"    => "1",
            "anw_sem1"     => "1",
            "anw_sem2"     => "1",
            "anw_sem3"     => "1",
            "anw_sem4"     => "1",
            "anw_sem5"     => "0",
            "anw_sem6"     => "0",
            "anw_sem7"     => "0",
            "anw_sem8"     => "0",
            "anw_sem9"     => "0",
            "best_sem1"    => "1",
            "best_sem2"    => "1",
            "best_sem3"    => "1",
            "best_sem4"    => "1",
            "best_sem5"    => "0",
            "best_sem6"    => "0",
            "best_sem7"    => "0",
            "best_sem8"    => "0",
            "best_sem9"    => "0",
            "best_sem10"   => "0",
            "voraus_sem4"  => "1",
            "voraus_sem5"  => "1",
            "voraus_sem6"  => "1",
            "voraus_sem7"  => "1",
            "voraus_sem8"  => "0",
            "voraus_sem9"  => "0",
        ];
        $this->assertTrue($studiDataObjects[0]->equals(
            StudiData::fromValues(
                Matrikelnummer::fromInt(221231),
                Vorname::fromString("Marika"),
                Nachname::fromString("Heißler"),
                $dataLine
            )
        ));

        $this->assertTrue($studiDataObjects[15]->getNachname()->equals(
            Nachname::fromString("von der Stääts-Lüdenscheid")
        ));
    }
}