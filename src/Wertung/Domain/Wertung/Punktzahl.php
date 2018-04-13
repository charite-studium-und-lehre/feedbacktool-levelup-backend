<?php

namespace Wertung\Domain\Wertung;

use Assert\Assertion;

class Punktzahl
{
    const MAX_PUNKTZAHL = 1000;

    const INVALID_WERT = "Punktzahl darf max. " . self::MAX_PUNKTZAHL . " (+/-) sein: ";

    const INVALID_WERT_ZU_GENAU = "Punktzahlen dürfen höchstens eine Nachkommastelle haben: ";

    /** @var float */
    private $value;

    public static function fromFloat(float $punktzahl): Punktzahl {
        Assertion::between($punktzahl,
                           -self::MAX_PUNKTZAHL,
                           self::MAX_PUNKTZAHL,
                           self::INVALID_WERT . $punktzahl
        );
        Assertion::eq($punktzahl,
                      intval($punktzahl * 10) / 10,
                      self::INVALID_WERT_ZU_GENAU . $punktzahl
        );

        $object = new self();
        $object->value = $punktzahl;

        return $object;
    }

    public function getAnteilVon(Punktzahl $anderePunktzahl): float {
        return $this->getValue() / $anderePunktzahl->getValue();
    }

    public function getValue() {
        return $this->value;
    }
}