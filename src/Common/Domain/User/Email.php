<?php

namespace Common\Domain\User;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class Email implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const UNGUELTIG = "Die Mailadresse ist ungültig: ";

    private string $value;

    public static function fromString(string $value): self {
        Assertion::email($value, self::UNGUELTIG . $value);

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