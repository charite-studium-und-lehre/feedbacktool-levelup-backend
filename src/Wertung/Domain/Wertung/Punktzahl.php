<?php

namespace Wertung\Domain\Wertung;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

class Punktzahl
{
    use DefaultValueObjectComparison;

    const MAX_PUNKTZAHL = 1000;
    const NACHKOMMASTELLEN = 2;

    const INVALID_WERT = "Punktzahl darf max. " . self::MAX_PUNKTZAHL . " (+/-) sein: ";
    const INVALID_WERT_ZU_GENAU = "Punktzahlen dürfen höchstens " . self::NACHKOMMASTELLEN
    . " Nachkommastellen haben: ";

    /** @var float */
    private $value;

    public static function fromFloat(float $punktzahl): Punktzahl {
        Assertion::between($punktzahl,
                           -self::MAX_PUNKTZAHL,
                           self::MAX_PUNKTZAHL,
                           self::INVALID_WERT . $punktzahl
        );
        Assertion::eq(0,
                      ((int) ($punktzahl * (10 ** self::NACHKOMMASTELLEN))) -
                      ($punktzahl * (10 ** self::NACHKOMMASTELLEN)),
                      self::INVALID_WERT_ZU_GENAU . $punktzahl
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