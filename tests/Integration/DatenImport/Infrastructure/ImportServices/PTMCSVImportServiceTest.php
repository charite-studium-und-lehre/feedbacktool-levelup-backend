<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use Cluster\Domain\ClusterTyp;
use DatenImport\Domain\CharitePTMPersistenzService;
use DatenImport\Infrastructure\Persistence\CharitePTMCSVImportService;
use PHPUnit\Framework\TestCase;

class PTMCSVImportServiceTest extends TestCase
{

    public function testGetCSVDataMatrikelNr() {

        $service = new CharitePTMCSVImportService();

        $data = $service->getData(
            __DIR__ . "/TESTEinzeldaten Berlin PT38(gesamt).csv",
            ";"
        );

        $this->assertCount(9, $data);

        $this->assertEquals(111119, array_keys($data)[8]);

        $this->assertEquals(222222, array_keys($data)[0]);

//        $this->assertEquals(0,
//                            $data['222222']
//                            [ClusterTyp::getOrgansystemTyp()->getConst()]
//                            ['akl']
//                            [CharitePTMPersistenzService::TYP_RICHTIG]);
//
//        $this->assertEquals(19,
//                            $data['222222']
//                            [ClusterTyp::getOrgansystemTyp()->getConst()]
//                            ['atm']
//                            [CharitePTMPersistenzService::TYP_WEISSNICHT]);

        $this->assertEquals(2,
                            $data['111116']
                            [ClusterTyp::getFachTyp()->getConst()]
                            ['ana']
                            [CharitePTMPersistenzService::TYP_FALSCH]);

    }
}