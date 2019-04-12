<?php

namespace Tests\Unit\Wertung\Domain\Wertung;

use PHPUnit\Framework\TestCase;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\Punktzahl;

class PunktWertungTest extends TestCase
{
    public function testFromPunktzahlUndSkala() {
        $punktzahl = Punktzahl::fromFloat(5);
        $skala = PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(20));

        $punktWertung = PunktWertung::fromPunktzahlUndSkala($punktzahl, $skala);

        $this->assertEquals(0.25, $punktWertung->getRelativeWertung());
        $this->assertEquals(5, $punktWertung->getPunktzahl()->getValue());
    }

    public function testFromPunktzahlUndSkalaMitKommentar() {
        $punktzahl = Punktzahl::fromFloat(800);
        $skala = PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(20));

        $punktWertung = PunktWertung::fromPunktzahlUndSkala($punktzahl, $skala);

        $this->assertEquals($punktzahl, $punktWertung->getPunktzahl());
    }
}