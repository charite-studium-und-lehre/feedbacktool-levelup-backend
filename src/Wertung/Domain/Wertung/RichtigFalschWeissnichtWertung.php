<?php

namespace Wertung\Domain\Wertung;

use Exception;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Skala\Skala;

class RichtigFalschWeissnichtWertung extends AbstractWertung
{

    protected Punktzahl $punktzahlRichtig;

    protected Punktzahl $punktzahlFalsch;

    protected Punktzahl $punktzahlWeissnicht;

    protected PunktSkala $skala;

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
     * @param Wertung[] $wertungen
     * @return Wertung
     */
    public static function getSummenWertung(array $wertungen) {
        $richtigWertungen = [];
        $falschWertungen = [];
        $weissnichtWertungen = [];

        foreach ($wertungen as $wertung) {
            if (!$wertung instanceof RichtigFalschWeissnichtWertung) {
                throw new Exception("Muss RichtigFalschWeissnichtWertung sein!" . get_class($wertung));
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

    public function getSkala(): Skala {
        return $this->skala;
    }

    public function getRelativeWertung(): float {
        return $this->punktzahlRichtig->getValue() / $this->skala->getMaxPunktzahl();
    }

    /**
     * @param Wertung[] $wertungen
     */
    public static function getDurchschnittsWertung(array $wertungen): RichtigFalschWeissnichtWertung {
        $richtigWertungen = [];
        $falschWertungen = [];

        foreach ($wertungen as $wertung) {
            if (!$wertung instanceof RichtigFalschWeissnichtWertung) {
                throw new Exception("Muss RichtigFalschWeissnichtWertung sein!" . get_class($wertung));
            }
            $richtigWertungen[] = $wertung->getRichtigFalschWeissnichtWertung()
                ->getPunktzahlRichtig()->getValue();
            $falschWertungen[] = $wertung->getRichtigFalschWeissnichtWertung()
                ->getPunktzahlFalsch()->getValue();
        }
        $anzahlGesamtPunkte = $wertungen[0]->getRichtigFalschWeissnichtWertung()->getGesamtPunktzahl()->getValue();
        $durchschnittRichtig = self::getDurchschnittAusZahlen($richtigWertungen);
        $durchschnittFalsch = self::getDurchschnittAusZahlen($falschWertungen);
        $durchschnittWeissnicht = $anzahlGesamtPunkte - $durchschnittRichtig - $durchschnittFalsch;

        return RichtigFalschWeissnichtWertung::fromPunktzahlen(
            Punktzahl::fromFloat($durchschnittRichtig),
            Punktzahl::fromFloat($durchschnittFalsch),
            Punktzahl::fromFloat($durchschnittWeissnicht)
        );
    }

    /**
     * @param float[] $zahlen
     */
    protected static function getDurchschnittAusZahlen(array $zahlen): float {
        return round(array_sum($zahlen) / count($zahlen));
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

    public function getGesamtPunktzahl(): Punktzahl {
        return
            Punktzahl::fromFloat(
                $this->punktzahlRichtig->getValue()
                + $this->punktzahlFalsch->getValue()
                + $this->punktzahlWeissnicht->getValue()
            );
    }

}