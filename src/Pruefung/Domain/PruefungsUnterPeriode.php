<?php

namespace Pruefung\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class PruefungsUnterPeriode implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const INVALID_PRUEFUNGS_UNTER_PERIODE = "Die Unterperiode von Prüfungen ist, wenn gegeben, "
    . "eine Zahl zwischen 1 und 9!";

    private int $value;

    public static function fromInt(int $value): self {
        Assertion::integerish($value, self::INVALID_PRUEFUNGS_UNTER_PERIODE);
        Assertion::between($value, 1, 9, self::INVALID_PRUEFUNGS_UNTER_PERIODE);

        $object = new self();
        $object->value = $value;

        return $object;
    }

    public function getValue(): int {
        return $this->value;
    }

    public function __toString(): string {
        return (string) $this->value;
    }

}