<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use Cluster\Domain\ClusterTyp;
use DatenImport\Domain\CharitePTMPersistenzService;
use DatenImport\Domain\FachCodeKonstanten;
use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use DatenImport\Infrastructure\Persistence\CharitePTMCSVImportService;
use PHPUnit\Framework\TestCase;

class PTMCSVImportServiceTest extends TestCase
{

    public function testGetCSVDataMatrikelNr() {

        $service = new CharitePTMCSVImportService(
            [
                AbstractCSVImportService::INPUTFILE_OPTION =>
                    __DIR__ . "/TESTEinzeldaten Berlin PT38(gesamt).csv",
                AbstractCSVImportService::HAS_HEADERS_OPTION => TRUE
            ]

        );
        $data = $service->getData();

        $this->assertCount(9, $data);

        $this->assertEquals(111119, array_keys($data)[8]);

        $this->assertEquals(111111, array_keys($data)[0]);

        $this->assertEquals(0,
                            $data['111111']
                            [ClusterTyp::getOrgansystemTyp()->getConst()]
                            [CharitePTMCSVImportService::ORGANSYSTEM_KUERZEL['akl']]
                            [CharitePTMPersistenzService::TYP_RICHTIG]);

        $this->assertEquals(19,
                            $data['111111']
                            [ClusterTyp::getOrgansystemTyp()->getConst()]
                            [CharitePTMCSVImportService::ORGANSYSTEM_KUERZEL['atm']]
                            [CharitePTMPersistenzService::TYP_WEISSNICHT]);

        $this->assertEquals(2,
                            $data['111116']
                            [ClusterTyp::getFachTyp()->getConst()]
                            [FachCodeKonstanten::PTM_FACH_KUERZEL['ana']]
                            [CharitePTMPersistenzService::TYP_FALSCH]);



    }
}