<?php

namespace Wertung\Domain\Wertung;

use Assert\Assertion;

class Prozentzahl
{
    const NACHKOMMASTELLEN = 2;

    const INVALID_WERT = "Eine Prozentwertung muss zwischen 0 und 1 liegen: ";
    const INVALID_WERT_ZU_GENAU = "Prozentwert-Floats dürfen höchstens " . (self::NACHKOMMASTELLEN + 2)
    . " Nachkommastellen haben (also " . self::NACHKOMMASTELLEN . " Nachkommastellen der Prozentzahl): ";

    /** @var float */
    private $prozentzahl;

    public static function fromFloat(float $prozentWert): Prozentzahl {
        Assertion::between($prozentWert, 0, 1, self::INVALID_WERT . $prozentWert);
        Assertion::eq(0,
                      ((int) ($prozentWert * 100 * (10 ** self::NACHKOMMASTELLEN)))
                      - $prozentWert * 100 * (10 ** self::NACHKOMMASTELLEN),
                      self::INVALID_WERT_ZU_GENAU . $prozentWert
        );

        $object = new self();
        $object->prozentzahl = $prozentWert;

        return $object;
    }

    public function getValue(): float {
        return $this->prozentzahl;
    }

    public function getProzentWert(): float {
        return $this->prozentzahl * 100;
    }
}