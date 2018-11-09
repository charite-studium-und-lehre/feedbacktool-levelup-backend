<?php

namespace Common\Domain;

use Assert\Assertion;

class AggregateIdString
{
    use DefaultValueObjectComparison;

    const INVALID_ID = "Ist keine gültige ID: ";

    protected $id;

    public static function fromInt(string $id) {
        return static::fromString($id);
    }

    public static function fromString(string $id) {
        Assertion::string($id, 0, self::INVALID_ID . $id);

        $object = new static();
        $object->id = $id;

        return $object;
    }

    public function __toString(): string {
        return $this->getValue();
    }

    public function getValue(): string {
        return $this->id;
    }

}