<?php

namespace Common\Domain;

use Assert\Assertion;

class AggregateId
{
    use DefaultValueObjectComparison;

    const INVALID_ID = "Ist keine gültige ID: ";

    protected $id;

    public static function fromInt(string $id) {
        Assertion::integerish($id, self::INVALID_ID . $id);
        Assertion::greaterThan($id, 0, self::INVALID_ID . $id);

        $object = new static();
        $object->id = $id;

        return $object;
    }

    public function __toString(): string {
        return (string) $this->getValue();
    }

    public function getValue(): int {
        return $this->id;
    }

}