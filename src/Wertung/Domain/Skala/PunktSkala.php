<?php

namespace Wertung\Domain\Skala;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;
use Wertung\Domain\Wertung\Punktzahl;

class PunktSkala implements Skala
{
    use DefaultValueObjectComparison;

    const INVALID_GROESSER_NULL = "Eine Punktskala darf keine negative maximale Punktzahl haben: ";

    private Punktzahl $maxPunktzahl;

    public static function fromMaxPunktzahl(Punktzahl $maxPunktzahl): PunktSkala {
        Assertion::greaterOrEqualThan($maxPunktzahl->getValue(), 0,
                                      self::INVALID_GROESSER_NULL . $maxPunktzahl->getValue());
        $object = new self();
        $object->maxPunktzahl = $maxPunktzahl;

        return $object;
    }

    public function getMaxPunktzahl(): Punktzahl {
        return $this->maxPunktzahl;
    }
}