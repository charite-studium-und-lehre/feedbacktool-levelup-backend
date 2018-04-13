<?php

namespace Wertung\Domain\Wertung;

use Assert\Assertion;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Skala\Skala;

class PunktWertung extends AbstractWertung
{
    /** @var Punktzahl */
    private $punktzahl;
    /** @var PunktSkala */
    private $skala;

    public static function fromPunktzahlUndSkala(Punktzahl $punktzahl, PunktSkala $skala, string $kommentar = NULL): PunktWertung {
        Assertion::nullOrString($kommentar);
        $object = new self();
        $object->punktzahl = $punktzahl;
        $object->skala = $skala;
        $object->kommentar = $kommentar;

        return $object;
    }

    /**
     * @see Wertung::getRelativeWertung()
     * @return float
     */
    public function getRelativeWertung(): float {
        return $this->punktzahl->getAnteilVon($this->skala->getMaxPunktzahl());
    }

    /**
     * @see Wertung::getSkala()
     * @return Skala
     */
    public function getSkala(): Skala {
        return ProzentSkala::create();
    }

    public function getPunktzahl(): Punktzahl {
        return $this->punktzahl;
    }
}