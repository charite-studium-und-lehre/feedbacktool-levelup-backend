<?php

namespace Tests\Unit\Wertung\Domain\Wertung;


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

    public function testFromFloat_FalschNull() {
        $value = 0;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(PunktSkala::INVALID_GROESSER_NULL);

        PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat($value));
    }

    public function testFromFloat_FalschNegativ() {
        $value = -1;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(PunktSkala::INVALID_GROESSER_NULL);

        PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat($value));
    }
}