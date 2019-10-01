<?php

namespace Tests\Unit\Pruefung\Domain;

use PHPUnit\Framework\TestCase;
use Pruefung\Domain\PruefungsUnterPeriode;

class PruefungsUnterPeriodeTest extends TestCase
{

    public function testFromInt1() {
        $object = PruefungsUnterPeriode::fromInt(1);
        $this->assertEquals(1, $object->getValue());
    }

    public function testFromInt2() {
        $object = PruefungsUnterPeriode::fromInt(9);
        $this->assertEquals(9, $object->getValue());
    }

    public function testFromInt_FalscheUnterperiode() {
        $this->expectExceptionMessage(PruefungsUnterPeriode::INVALID_PRUEFUNGS_UNTER_PERIODE);
        PruefungsUnterPeriode::fromInt(10);
    }

}