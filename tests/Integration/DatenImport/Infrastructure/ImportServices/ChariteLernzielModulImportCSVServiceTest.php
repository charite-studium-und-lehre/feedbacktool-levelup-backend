<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use Cluster\Domain\ClusterTitel;
use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\ChariteLernzielModulImportCSVService;
use PHPUnit\Framework\TestCase;
use Studi\Domain\MatrikelnummerMitStudiHash;

class ChariteLernzielModulImportCSVServiceTest extends TestCase
{

    public function testGetCSVData() {

        $csvImportService =
            new ChariteLernzielModulImportCSVService(
                [
                    AbstractCSVImportService::INPUTFILE_OPTION => __DIR__ . "/Lernziel-Module.csv",
                    AbstractCSVImportService::DELIMITER_OPTION => ";",
                ]
            );
        $lzModulData = $csvImportService->getLernzielZuModulData();

        $this->assertCount(4847, $lzModulData);

        $this->assertEquals(array_keys($lzModulData)[0], 688);
        $this->assertTrue($lzModulData[688]->equals(ClusterTitel::fromString("M03")));
        $this->assertEquals(array_keys($lzModulData)[4846], 115818);
        $this->assertTrue($lzModulData[115818]->equals(ClusterTitel::fromString("M36")));
    }
}