<?php

namespace Tests\Unit\Wertung\Domain\Wertung;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Wertung\Domain\Wertung\Punktzahl;

class PunktZahlTest extends TestCase
{
    public function testFromFloat() {
        $value = 10.5;
        $punktZahl = Punktzahl::fromFloat($value);

        $this->assertEquals($value, $punktZahl->getValue());
    }

    public function testAnteil() {
        $value1 = 10.5;
        $punktZahl1 = Punktzahl::fromFloat($value1);
        $value2 = 20.5;
        $punktZahl2 = Punktzahl::fromFloat($value2);

        $this->assertEquals($value1 / $value2,$punktZahl1->getAnteilVon($punktZahl2));
    }

    public function testFromFloat_FalschZuGross() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Punktzahl::INVALID_WERT);

        $value = Punktzahl::MAX_PUNKTZAHL + 1;
        Punktzahl::fromFloat($value);
    }

    public function testFromFloat_FalschZuKlein() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Punktzahl::INVALID_WERT);

        $value = - Punktzahl::MAX_PUNKTZAHL - 1;
        Punktzahl::fromFloat($value);
    }

    public function testFromFloat_FalschZuGenau() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Punktzahl::INVALID_WERT_ZU_GENAU);

        $value = 101.12;
        Punktzahl::fromFloat($value);
    }


}