<?php

namespace Studi\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

final class Matrikelnummer implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const MIN_VALUE = 100_000;
    const MAX_VALUE = 10_000_000;

    const INVALID_STELLEN = "Die Matrikelnummer muss sechs- oder siebenstellig sein: ";

    private int $value;

    public static function fromInt(int $value): self {
        Assertion::integerish($value);

        $value = $value;
        Assertion::greaterOrEqualThan($value, self::MIN_VALUE, self::INVALID_STELLEN . $value);
        Assertion::lessOrEqualThan($value, self::MAX_VALUE, self::INVALID_STELLEN . $value);

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