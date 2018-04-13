<?php

namespace Wertung\Domain\Skala;

use Assert\Assertion;
use Wertung\Domain\Wertung\Punktzahl;

class PunktSkala implements Skala
{
    /** @var Punktzahl */
    private $maxPunktzahl;

    const INVALID_GROESSER_NULL = "Eine Punktskala muss eine maximale Punktzahl > 0 haben: ";

    public static function fromMaxPunktzahl(Punktzahl $maxPunktzahl) : PunktSkala {
        Assertion::greaterThan($maxPunktzahl->getValue(), 0,
                               self::INVALID_GROESSER_NULL . $maxPunktzahl->getValue());
        $object = new self();
        $object->maxPunktzahl = $maxPunktzahl;
        return $object;
    }

    public function getMaxPunktzahl(): Punktzahl {
        return $this->maxPunktzahl;
    }
}