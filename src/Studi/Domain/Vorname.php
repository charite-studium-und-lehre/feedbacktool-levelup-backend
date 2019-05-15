<?php

namespace Studi\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

final class Vorname implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const MIN_LENGTH = 2;
    const MAX_LENGTH = 30;

    const UNGUELTIG = "Der Vorname ist ungültig: ";
    const UNGUELTIG_ZU_KURZ = "Der Vorname ist zu kurz: ";
    const UNGUELTIG_ZU_LANG = "Der Vorname ist zu lang: ";

    private $value;

    public static function fromString(string $value): self {
        Assertion::String($value, self::UNGUELTIG . $value);
        Assertion::eq(trim($value), $value, self::UNGUELTIG . $value);
        Assertion::minLength($value, self::MIN_LENGTH, self::UNGUELTIG_ZU_KURZ . $value);
        Assertion::maxLength($value, self::MAX_LENGTH, self::UNGUELTIG_ZU_LANG . $value);

        $object = new self();
        $object->value = $value;

        return $object;
    }

    public function getValue() {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value;
    }

}