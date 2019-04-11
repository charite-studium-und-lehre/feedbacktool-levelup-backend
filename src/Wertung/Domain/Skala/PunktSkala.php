<?php

namespace Wertung\Domain\Skala;

use Assert\Assertion;
use Wertung\Domain\Wertung\Punktzahl;

class PunktSkala implements Skala
{
    const INVALID_GROESSER_NULL = "Eine Punktskala darf keine negative maximale Punktzahl haben: ";

    /** @var Punktzahl */
    private $maxPunktzahl;

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