<?php

namespace Wertung\Domain\Wertung;

use Exception;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Skala\Skala;

class PunktWertung extends AbstractWertung
{
    protected Punktzahl $punktzahl;

    protected Skala $skala;

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
    public static function getDurchschnittsWertung(array $wertungen): PunktWertung {
        $punktzahlen = [];
        $maxPunkte = [];
        foreach ($wertungen as $wertung) {
            $punktzahlen[] = $wertung->getPunktzahl()->getValue();
            $maxPunkte[] = $wertung->getSkala()->getMaxPunktzahl()->getValue();
        }

        return PunktWertung::fromPunktzahlUndSkala(
            Punktzahl::fromFloatMitRunden(
                self::getDurchschnittAusZahlen($punktzahlen)
            ),
            PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloatMitRunden(
                self::getDurchschnittAusZahlen($maxPunkte)))
        );

    }

    public static function getSummenWertung(array $wertungen) {
        $punktzahlen = [];
        $skalaMaxPunkte = [];

        foreach ($wertungen as $wertung) {
            if (!$wertung instanceof PunktWertung) {
                throw new Exception("Muss Punktwertung sein!" . get_class($wertung));
            }
            $punktzahlen[] = $wertung->getPunktzahl()->getValue();
            $skalaMaxPunkte[] = $wertung->getSkala()->getMaxPunktzahl()->getValue();
        }

        return PunktWertung::fromPunktzahlUndSkala(
            Punktzahl::fromFloatMitRunden(
                self::getSummeAusZahlen($punktzahlen)),
            PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloatMitRunden(
                self::getDurchschnittAusZahlen($skalaMaxPunkte) * count($wertungen)
            )
            )
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
