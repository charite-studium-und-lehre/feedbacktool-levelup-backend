<?php

namespace Pruefung\Domain\FrageAntwort;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;

final class Frage implements DDDEntity
{
    use DefaultEntityComparison;

    private $frage;

    public static function fromInt(string $value): self {
        Assertion::integerish($value);

        $value = (int) $value;
        Assertion::greaterOrEqualThan($value, self::MIN_VALUE, self::INVALID_STELLEN . $value);
        Assertion::lessOrEqualThan($value, self::MAX_VALUE, self::INVALID_STELLEN . $value);

        $object = new self();
        $object->value = $value;

        return $object;
    }

    public function getValue(): string {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value;
    }

}