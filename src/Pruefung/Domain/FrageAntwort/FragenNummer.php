<?php

namespace Pruefung\Domain\FrageAntwort;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

final class FragenNummer implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const MIN_VALUE = 1;
    const MAX_VALUE = 1_000_000;

    const INVALID_TEXT = "Keine Fragennummer: ";

    private int $value;

    public static function fromInt(int $value): self {
        Assertion::numeric($value);

        Assertion::between(
            $value,
            self::MIN_VALUE,
            self::MAX_VALUE,
            self::INVALID_TEXT . $value
        );

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