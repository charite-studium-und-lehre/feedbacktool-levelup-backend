<?php

namespace Tests\Unit\Pruefung\Domain;

use FBToolCommon\Domain\Zeitsemester;
use PHPUnit\Framework\TestCase;
use Pruefung\Domain\PruefungsPeriode;
use Pruefung\Domain\PruefungsUnterPeriode;

class PruefungsPeriodeTest extends TestCase
{

    public function testFromInt1() {
        $pruefungsPeriode = PruefungsPeriode::fromInt(20141);
        $this->assertEquals("SoSe2014", $pruefungsPeriode->getZeitsemester()->getStandardString());
        $this->assertNull( $pruefungsPeriode->getUnterPeriode());
    }

    public function testFromInt2() {
        $pruefungsPeriode = PruefungsPeriode::fromInt(201412);
        $this->assertEquals("SoSe2014", $pruefungsPeriode->getZeitsemester()->getStandardString());
        $this->assertEquals(2, $pruefungsPeriode->getUnterPeriode()->getValue());
    }


    public function testFromZeitsemester() {
        $pruefungsPeriode = PruefungsPeriode::fromZeitsemester(
            Zeitsemester::fromString("WiSe2018")
        );
        $this->assertEquals($pruefungsPeriode, PruefungsPeriode::fromInt(20182));
    }

    public function testFromZeitsemesterUndUnterPeriode() {
        $pruefungsPeriode = PruefungsPeriode::fromZeitsemesterUndPeriode(
            Zeitsemester::fromString("WiSe2018"),
            PruefungsUnterPeriode::fromInt(5)
        );
        $this->assertEquals($pruefungsPeriode->toInt(), 201825);
    }

    public function testFromString_FalscheUnterperiode() {
        $this->expectExceptionMessage(PruefungsUnterPeriode::INVALID_PRUEFUNGS_UNTER_PERIODE);
        PruefungsUnterPeriode::fromInt(10);
    }

}