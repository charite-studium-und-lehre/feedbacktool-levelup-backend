<?php

namespace Tests\Unit\DatenImport\Infrastructure;


use DatenImport\Infrastructure\Persistence\PTMCSVImportService;
use PHPUnit\Framework\TestCase;
use Studi\Domain\MatrikelnummerMitStudiHash;

class PTMCSVImportServiceTest extends TestCase
{


    public function testGetCSVDataMatrikelNr(){

        $service = new PTMCSVImportService();
        $PTMDataArray = $service->getCSVDataAsArray(__DIR__ . "/TestFilePTM.csv");
        $matnr = $PTMDataArray[0]['Matrikelnummer'];

        $object = MatrikelnummerMitStudiHash::fromInt("123456");

        $this->assertNotEquals($object->getValue(), $matnr);


    }
}