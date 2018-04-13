<?php

namespace Tests\Unit\Wertung\Domain\Wertung;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Wertung\Domain\Wertung\Prozentzahl;

class ProzentzahlTest extends TestCase
{
    public function testFromFloat() {
        $value = 0.18;
        $prozentzahl = Prozentzahl::fromFloat($value);

        $this->assertEquals(0.18, $prozentzahl->getValue());
        $this->assertEquals(18, $prozentzahl->getProzentWert());
    }

    public function testFromFloat_FalschZuKlein() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Prozentzahl::INVALID_WERT);

        $value = -0.01;
        Prozentzahl::fromFloat($value);
    }

    public function testFromFloat_FalschZuGross() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Prozentzahl::INVALID_WERT);

        $value = 101;
        Prozentzahl::fromFloat($value);
    }


}