<?php

namespace Wertung\Domain\Wertung;

use Exception;
use Wertung\Domain\Skala\ProzentSkala;
use Wertung\Domain\Skala\Skala;

class ProzentWertung extends AbstractWertung
{
    private Prozentzahl $prozentzahl;

    public static function fromProzentzahl(Prozentzahl $prozentzahl): self {

        $object = new self();
        $object->prozentzahl = $prozentzahl;

        return $object;
    }

    /**
     * @param Wertung[] $wertungen
     * @return Wertung
     */
    public static function getDurchschnittsWertung(array $wertungen) {
        $prozentzahlen = [];

        foreach ($wertungen as $wertung) {
            if (!$wertung instanceof ProzentWertung) {
                throw new Exception("Muss ProzentWertung sein!" . get_class($wertung));
            }
            $prozentzahlen[] = $wertung->getProzentzahl()->getValue();
        }

        return ProzentWertung::fromProzentzahl(

            Prozentzahl::fromFloat(
                round(
                    self::getDurchschnittAusZahlen($prozentzahlen),
                    2
                ),
                )
        );
    }

    /**
     * @return float
     * @see Wertung::getRelativeWertung()
     */
    public function getRelativeWertung(): float {
        return $this->prozentzahl->getValue();
    }

    /**
     * @return Skala
     * @see Wertung::getSkala()
     */
    public function getSkala(): Skala {
        return ProzentSkala::create();
    }

    public function equals(object $otherObject): bool {
        if (!($otherObject instanceof ProzentWertung)) {
            return FALSE;
        }

        return $this->prozentzahl->equals($otherObject->getProzentzahl());
    }

    public static function getSummenWertung(array $wertungen) {
        throw new Exception("Macht hier keinen Sinn!");
    }

    public function getProzentzahl(): Prozentzahl {
        return $this->prozentzahl;
    }
}