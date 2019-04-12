<?php

namespace Tests\Unit\Wertung\Domain\Wertung;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Wertung\Domain\Wertung\ProzentWertung;
use Wertung\Domain\Wertung\Prozentzahl;

class ProzentWertungTest extends TestCase
{
    public function testFromProzentzahlUndSkala() {
        $prozentZahl = 0.18;
        $prozentWertung = ProzentWertung::fromProzentzahl(Prozentzahl::fromFloat($prozentZahl));

        $this->assertEquals($prozentZahl, $prozentWertung->getRelativeWertung());
        $this->assertEquals(18, $prozentWertung->getProzentzahl()->getProzentWert());
    }

    public function testFalsch_ZuHoheGenauigkeit() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Prozentzahl::INVALID_WERT_ZU_GENAU);
        $prozentZahl = .18585;
        ProzentWertung::fromProzentzahl(Prozentzahl::fromFloat($prozentZahl));
    }

}