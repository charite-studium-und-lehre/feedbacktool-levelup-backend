<?php

namespace Wertung\Domain\Wertung;

use Assert\Assertion;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Skala\Skala;

class PunktWertung extends AbstractWertung
{
    /** @var Punktzahl */
    protected $punktzahl;
    /** @var PunktSkala */
    protected $skala;

    public static function fromPunktzahlUndSkala(Punktzahl $punktzahl, PunktSkala $skala, string $kommentar = NULL): PunktWertung {
        Assertion::nullOrString($kommentar);
        $object = new static();
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
        return PunktSkala::fromMaxPunktzahl($this->skala->getMaxPunktzahl());
    }

    public function getPunktzahl(): Punktzahl {
        return $this->punktzahl;
    }
}