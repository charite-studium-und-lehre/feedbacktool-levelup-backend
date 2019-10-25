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
    public static function getDurchschnittsWertung(array $wertungen): PunktWertung {
        $punktSummenWertung = self::getSummenWertung($wertungen)->getPunktWertung();

        return PunktWertung::fromPunktzahlUndSkala(
            Punktzahl::fromFloat(
                round($punktSummenWertung->getPunktzahl()->getValue() / count($wertungen), 2)),
            PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(count($wertungen)))
        );
    }

    public static function getSummenWertung(array $wertungen) {
        $punktzahlen = [];
        $ersteWertung = $wertungen[0];
        $skalaMaxPunkte = [];

        foreach ($wertungen as $wertung) {
            if (!$wertung instanceof PunktWertung) {
                throw new \Exception("Muss Punktwertung sein!" . get_class($wertung));
            }
            $punktzahlen[] = $wertung->getPunktzahl()->getValue();
            $skalaMaxPunkte[] = $wertung->getSkala()->getMaxPunktzahl()->getValue();
        }

        return PunktWertung::fromPunktzahlUndSkala(
            Punktzahl::fromFloat(
                round(
                    self::getSummeAusZahlen($punktzahlen),
                    2
                )
            ),
            PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(
                round(
                    self::getSummeAusZahlen($skalaMaxPunkte),
                    2
                ))
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
