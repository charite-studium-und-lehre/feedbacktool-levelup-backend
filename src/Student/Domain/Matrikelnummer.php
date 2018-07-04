<?php

namespace Student\Domain;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

final class Matrikelnummer
{
    use DefaultValueObjectComparison;

    const MIN_VALUE = 100000;
    const MAX_VALUE = 1000000;

    const INVALID_STELLEN = "Die Matrikelnummer muss sechsstellig sein: ";

    private $value;


    public static function fromInt(string $value): self {
        Assertion::integerish($value);

        $value = (int) $value;
        Assertion::greaterOrEqualThan($value, self::MIN_VALUE, self::INVALID_STELLEN);
        Assertion::lessOrEqualThan($value, self::MAX_VALUE, self::INVALID_STELLEN);

        $object = new self();
        $object->value = $value;

        return $object;
    }

    public function getValue() {
        return $this->value;
    }

    public function __toString() {
        return $this->value;
    }

}