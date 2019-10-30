<?php

namespace Pruefung\Domain\FrageAntwort;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

final class FragenNummer implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const MIN_VALUE = 1;
    const MAX_VALUE = 1000000;

    const INVALID_TEXT = "Keine Fragennummer:: ";

    /** @var int */
    private $value;

    public static function fromInt(string $value): self {
        Assertion::numeric($value);

        $value = (int) $value;

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

    public function getValue(): string {
        return $this->value;
    }

    public function __toString(): string {
        return (string) $this->value;
    }

}