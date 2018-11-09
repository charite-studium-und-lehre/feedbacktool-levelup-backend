<?php

namespace Studi\Domain;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

final class MatrikelHash
{
    use DefaultValueObjectComparison;

    const MIN_LENGTH = 2;
    const MAX_LENGTH = 30;

    const UNGUELTIG = "Scheint kein Matrikel-Hash zu sein: ";

    private $value;


    public static function fromString(string $value): self {
        Assertion::String($value, self::UNGUELTIG);
        Assertion::alnum($value, self::UNGUELTIG);
        Assertion::minLength($value, self::MIN_LENGTH, self::UNGUELTIG);
        Assertion::maxLength($value, self::MAX_LENGTH, self::UNGUELTIG);

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