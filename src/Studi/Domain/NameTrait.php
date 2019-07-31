<?php

namespace Studi\Domain;

use Assert\Assertion;

trait NameTrait
{
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