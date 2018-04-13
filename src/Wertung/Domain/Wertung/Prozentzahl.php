<?php

namespace Wertung\Domain\Wertung;

use Assert\Assertion;

class Prozentzahl
{
    const INVALID_WERT = "Prozentwertung muss zwischen 0 und 1 liegen: ";

    /** @var float */
    private $prozentzahl;

    public static function fromFloat(float $prozentWert): Prozentzahl {
        Assertion::between($prozentWert, 0, 1, self::INVALID_WERT . $prozentWert);

        $object = new self();
        $object->prozentzahl = $prozentWert;

        return $object;
    }

    public function getValue() {
        return $this->prozentzahl;
    }

    public function getProzentWert() {
        return $this->prozentzahl * 100;
    }
}