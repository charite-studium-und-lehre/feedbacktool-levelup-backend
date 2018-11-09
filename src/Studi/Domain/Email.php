<?php

namespace Studi\Domain;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

final class Email
{
    use DefaultValueObjectComparison;

    const UNGUELTIG = "Die Mailadresse ist ungültig: ";

    private $value;


    public static function fromString(string $value): self {
        Assertion::email($value, self::UNGUELTIG . $value);

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