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

    /**
     * @param RichtigFalschWeissnichtWertung[] $wertungen
     * @return RichtigFalschWeissnichtWertung
     */
    public static function getDurchschnittsWertung(array $wertungen) {
        $richtigWertungen = [];
        $falschWertungen = [];
        $weissnichtWertungen = [];

        foreach ($wertungen as $wertung) {
            if (!$wertung instanceof RichtigFalschWeissnichtWertung) {
                throw new \Exception("Muss RichtigFalschWeissnichtWertung sein!" . get_class($wertung));
            }
            $richtigWertungen[] = $wertung->getPunktzahlRichtig()->getValue();
            $falschWertungen[] = $wertung->getPunktzahlFalsch()->getValue();
            $weissnichtWertungen[] = $wertung->getPunktzahlWeissnicht()->getValue();
        }

        return RichtigFalschWeissnichtWertung::fromPunktzahlen(
            Punktzahl::fromFloat(
                round(self::getDurchschnittAusZahlen($richtigWertungen), 2),
                ),
            Punktzahl::fromFloat(
                round(self::getDurchschnittAusZahlen($falschWertungen), 2),
                ),
            Punktzahl::fromFloat(
                round(self::getDurchschnittAusZahlen($weissnichtWertungen), 2),
                ),
            );
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