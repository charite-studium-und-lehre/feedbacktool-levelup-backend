<?php

namespace Wertung\Domain\Wertung;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

class Punktzahl
{
    use DefaultValueObjectComparison;

    const MAX_PUNKTZAHL = 100_000;
    const NACHKOMMASTELLEN = 2;

    const INVALID_WERT = "Punktzahl darf max. " . self::MAX_PUNKTZAHL . " (+/-) sein: ";
    const INVALID_WERT_ZU_GENAU = "Punktzahlen dürfen höchstens " . self::NACHKOMMASTELLEN
    . " Nachkommastellen haben: ";

    private float $value;

    public static function fromFloatMitRunden(float $punktzahl): Punktzahl {
        return self::fromFloat(round($punktzahl, 2));
    }

    public static function fromFloat(float $punktzahl): Punktzahl {
        Assertion::between($punktzahl,
                           -self::MAX_PUNKTZAHL,
                           self::MAX_PUNKTZAHL,
                           self::INVALID_WERT . $punktzahl
        );
        $nachkommastellenArray = explode(".", (string) $punktzahl);
        $anzahlNachkommastellen = isset($nachkommastellenArray[1]) ? strlen($nachkommastellenArray[1]) : 0;
        Assertion::max(
            $anzahlNachkommastellen,
            2,
            self::INVALID_WERT_ZU_GENAU . $anzahlNachkommastellen . "-" . $punktzahl
        );

        $object = new self();
        $object->value = $punktzahl;

        return $object;
    }

    /** auf 2*X Nachkommastellen genau */
    public function getAnteilVon(Punktzahl $anderePunktzahl): float {
        return (round(((10 ** (2 * self::NACHKOMMASTELLEN)) * $this->getValue() / $anderePunktzahl->getValue())))
            / (10 ** (2 * self::NACHKOMMASTELLEN));
    }

    public function getValue(): float {
        return $this->value;
    }
}