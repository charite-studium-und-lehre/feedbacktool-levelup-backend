<?php

namespace Wertung\Domain\Wertung;

use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Skala\Skala;

class RichtigFalschWeissnichtWertung extends AbstractWertung
{

    /** @var Punktzahl */
    protected $punktzahlRichtig;

    /** @var Punktzahl */
    protected $punktzahlFalsch;

    /** @var Punktzahl */
    protected $punktzahlWeissnicht;

    /** @var PunktSkala */
    protected $skala;

    public static function fromPunktzahlen(
        Punktzahl $punktzahlRichtig,
        Punktzahl $punktzahlFalsch,
        Punktzahl $punktzahlWeissnicht
    ): self {

        $object = new self();

        $object->punktzahlRichtig = $punktzahlRichtig;
        $object->punktzahlFalsch = $punktzahlFalsch;
        $object->punktzahlWeissnicht = $punktzahlWeissnicht;
        $object->skala = PunktSkala::fromMaxPunktzahl(
            Punktzahl::fromFloat(
                $punktzahlRichtig->getValue()
                + $punktzahlFalsch->getValue()
                + $punktzahlWeissnicht->getValue()
            )
        );

        return $object;
    }

    public function getPunktzahlRichtig(): Punktzahl {
        return $this->punktzahlRichtig;
    }

    public function getPunktzahlFalsch(): Punktzahl {
        return $this->punktzahlFalsch;
    }

    public function getPunktzahlWeissnicht(): Punktzahl {
        return $this->punktzahlWeissnicht;
    }

    public function getSkala(): Skala {
        return $this->skala;
    }

    public function getRelativeWertung(): float {
        return $this->punktzahlRichtig->getValue() / $this->skala->getMaxPunktzahl();
    }
}