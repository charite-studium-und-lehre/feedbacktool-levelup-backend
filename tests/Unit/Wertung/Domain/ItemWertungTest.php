<?php

namespace Tests\Unit\Wertung\Domain;

use PHPUnit\Framework\TestCase;
use StudiPruefung\Domain\StudiPruefungsId;
use Wertung\Domain\ItemWertung;
use Wertung\Domain\ItemWertungsId;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\Punktzahl;

class ItemWertungTest extends TestCase
{

    public function testCreate() {

        $id = ItemWertungsId::fromInt("12345");
        $studiPruefungsId = StudiPruefungsId::fromInt("789");
        $wertung = PunktWertung::fromPunktzahlUndSkala(
            Punktzahl::fromFloat(4.5),
            PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(6))
        );

        $itemWertung = ItemWertung::create(
            $id,
            $studiPruefungsId,
            $wertung
        );

        $this->assertEquals("12345", $itemWertung->getId()->getValue());
        $this->assertEquals($studiPruefungsId, $itemWertung->getStudiPruefungsId());
        $this->assertEquals(0.75, $itemWertung->getWertung()->getRelativeWertung());
    }

}