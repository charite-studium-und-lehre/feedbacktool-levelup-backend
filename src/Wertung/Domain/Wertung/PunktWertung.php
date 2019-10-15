<?php

namespace Wertung\Domain\Wertung;

use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Skala\Skala;

class PunktWertung extends AbstractWertung
{
    /** @var Punktzahl */
    protected $punktzahl;

    /** @var PunktSkala */
    protected $skala;

    public static function fromPunktzahlUndSkala(Punktzahl $punktzahl, PunktSkala $skala): self {
        $object = new static();
        $object->punktzahl = $punktzahl;
        $object->skala = $skala;

        return $object;
    }

    /**
     * @param PunktWertung[] $wertungen
     * @return PunktWertung
     */
    public static function getDurchschnittsWertung(array $wertungen) {
        $punktzahlen = [];
        $ersteWertung = $wertungen[0];

        foreach ($wertungen as $wertung) {
            if (!$wertung instanceof PunktWertung) {
                throw new \Exception("Muss Punktwertung sein!" . get_class($wertung));
            }
            $punktzahlen[] = $wertung->getPunktzahl()->getValue();
        }

        return PunktWertung::fromPunktzahlUndSkala(

            Punktzahl::fromFloat(
                round(
                    self::getDurchschnittAusZahlen($punktzahlen),
                    2
                ),
                ),
            $ersteWertung->getSkala()
        );
    }

    /**
     * @return float
     * @see Wertung::getRelativeWertung()
     */
    public function getRelativeWertung(): float {
        return $this->punktzahl->getAnteilVon($this->skala->getMaxPunktzahl());
    }

    /**
     * @return PunktSkala
     * @see Wertung::getSkala()
     */
    public function getSkala(): Skala {
        return $this->skala;
    }

    public function getPunktzahl(): Punktzahl {
        return $this->punktzahl;
    }
}