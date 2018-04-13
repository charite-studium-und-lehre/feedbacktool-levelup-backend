<?php

namespace Tests\Unit\Wertung\Domain\Wertung;

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

    public function testFromStringMitKommentar() {
        $prozentZahl = 0.18;
        $prozentWertung = ProzentWertung::fromProzentzahl(
            Prozentzahl::fromFloat($prozentZahl),
            "Kommentar"
        );

        $this->assertEquals($prozentZahl, $prozentWertung->getRelativeWertung());
        $this->assertEquals("Kommentar", $prozentWertung->getKommentar());
    }

}