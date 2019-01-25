<?php

namespace Tests\Unit\Wertung\Domain\Skala;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Wertung\Punktzahl;

class PunktSkalaTest extends TestCase
{
    public function testFromFloat() {
        $value = 20;
        $punktSkala = PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat($value));

        $this->assertEquals($value, $punktSkala->getMaxPunktzahl()->getValue());
    }

    public function testFromFloat_Null() {
        $punktSkala = PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(0));
        $this->assertEquals(0, $punktSkala->getMaxPunktzahl()->getValue());
    }

    public function testFromFloat_FalschNegativ() {
        $value = -1;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(PunktSkala::INVALID_GROESSER_NULL);

        PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat($value));
    }
}