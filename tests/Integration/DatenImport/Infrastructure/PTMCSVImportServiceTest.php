<?php

namespace Tests\Unit\DatenImport\Infrastructure;


use DatenImport\Infrastructure\Persistence\CharitePTMCSVImportService;
use PHPUnit\Framework\TestCase;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;

class PTMCSVImportServiceTest extends TestCase
{


    public function testGetCSVDataMatrikelNr(){

        $service = new CharitePTMCSVImportService();
        $PTMDataArray = $service->getCSVDataAsArray(__DIR__ . "/TestFilePTM.csv");
        $matnr = $PTMDataArray[0]['Matrikelnummer'];

        $object = Matrikelnummer::fromInt("123456");

        $this->assertNotEquals($object->getValue(), $matnr);


    }
}