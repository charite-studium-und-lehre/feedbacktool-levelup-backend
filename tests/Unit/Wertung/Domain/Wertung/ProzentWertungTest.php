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

    public function testFalsch_ZuHoheGenauigkeit() {
        $prozentZahl = .18585;
        $prozentWertung = ProzentWertung::fromProzentzahl(Prozentzahl::fromFloat($prozentZahl));

        $this->assertNotEquals($prozentZahl, $prozentWertung->getRelativeWertung());
        $this->assertEquals(18.58, $prozentWertung->getProzentzahl()->getProzentWert());
    }

}