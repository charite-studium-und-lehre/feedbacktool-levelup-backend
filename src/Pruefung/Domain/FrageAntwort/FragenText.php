<?php

namespace Pruefung\Domain\FrageAntwort;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

final class FragenText implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const MIN_LENGTH = 5;
    const MAX_LENGTH = 2_000;

    const INVALID_TEXT = "Der Fragentext ist nicht gültig: ";

    private string $value;

    public static function fromInt(string $value): self {
        Assertion::string($value);

        Assertion::betweenLength($value, self::MIN_LENGTH,
                                 self::MAX_LENGTH, self::INVALID_TEXT . $value);

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