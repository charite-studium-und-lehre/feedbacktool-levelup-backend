<?php

namespace Tests\Unit\Studi\Domain;


use PHPUnit\Framework\TestCase;
use App\DatenImport\Infrastructure\Persistence\CSVImportService;
use Studi\Domain\Matrikelnummer;

class CSVImportServiceTest extends TestCase
{


    public function testGetCSVDataMatrikelNr(){

        $service = new CSVImportService();
        $PTMDataArray = $service->getCSVDataAsArray("TestFilePTM.csv");
        $matnr = $PTMDataArray[0]['Matrikelnummer'];

        $object = Matrikelnummer::fromInt("123456");

        $this->assertNotEquals($object->getValue(), $matnr);


    }
}