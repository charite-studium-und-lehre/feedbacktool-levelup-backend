<?php

namespace Wertung\Domain\Wertung;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

class Prozentzahl
{
    use DefaultValueObjectComparison;

    const NACHKOMMASTELLEN = 2;

    const INVALID_WERT = "Eine Prozentwertung muss zwischen 0 und 1 liegen: ";
    const INVALID_WERT_ZU_GENAU = "Prozentwert-Floats dürfen höchstens " . (self::NACHKOMMASTELLEN + 2)
    . " Nachkommastellen haben (also " . self::NACHKOMMASTELLEN . " Nachkommastellen der Prozentzahl): ";

    /** @var float */
    private $prozentzahl;

    public static function fromFloat(float $prozentWert): Prozentzahl {
        Assertion::between($prozentWert, 0, 1, self::INVALID_WERT . $prozentWert);

        $integerDifferenz = (round($prozentWert * 100 * (10 ** self::NACHKOMMASTELLEN)))
            - $prozentWert * 100 * (10 ** self::NACHKOMMASTELLEN);
        Assertion::false($integerDifferenz > 0.0000000001,
                         self::INVALID_WERT_ZU_GENAU . $prozentWert . " - " . $integerDifferenz
        );

        $object = new self();
        $object->prozentzahl = $prozentWert;

        return $object;
    }

    public static function fromFloatRunden(float $prozentWert): Prozentzahl {
        $prozentWert = round($prozentWert, self::NACHKOMMASTELLEN + 2);

        return self::fromFloat($prozentWert);
    }

    public function getValue(): float {
        return $this->prozentzahl;
    }

    public function getProzentWert(): float {
        return $this->prozentzahl * 100;
    }
}