<?php

namespace Tests\Unit\Pruefung\Domain;

use FBToolCommon\Domain\Zeitsemester;
use PHPUnit\Framework\TestCase;
use Pruefung\Domain\PruefungsPeriode;
use Pruefung\Domain\PruefungsUnterPeriode;

class PruefungsDatumEqualityTest extends TestCase
{

    public function testEquality() {
        $pruefungsPeriode1 = PruefungsPeriode::fromZeitsemesterUndPeriode(
            Zeitsemester::fromString("WiSe2014"),
            PruefungsUnterPeriode::fromInt(2)
        );
        $pruefungsPeriode2 = PruefungsPeriode::fromInt(201422);
        $this->assertTrue($pruefungsPeriode1->equals($pruefungsPeriode2));
    }

    public function testEqualityInt() {
        $pruefungsPeriode1 = PruefungsPeriode::fromInt(201420);
        $pruefungsPeriode2 = PruefungsPeriode::fromInt(20142);
        $this->assertTrue($pruefungsPeriode1->equals($pruefungsPeriode2));
    }

    public function testEquality_ungleich() {
        $pruefungsPeriode1 = PruefungsPeriode::fromInt(201411);
        $pruefungsPeriode2 = PruefungsPeriode::fromInt(201412);
        $this->assertFalse($pruefungsPeriode1->equals($pruefungsPeriode2));

    }

}