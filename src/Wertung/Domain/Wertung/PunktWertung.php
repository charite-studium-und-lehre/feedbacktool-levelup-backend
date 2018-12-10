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
     * @see WertungsInterface::getRelativeWertung()
     * @return float
     */
    public function getRelativeWertung(): float {
        return $this->punktzahl->getAnteilVon($this->skala->getMaxPunktzahl());
    }

    /**
     * @see WertungsInterface::getSkala()
     * @return PunktSkala
     */
    public function getSkala(): Skala {
        return $this->skala;
    }

    public function getPunktzahl(): Punktzahl {
        return $this->punktzahl;
    }
}