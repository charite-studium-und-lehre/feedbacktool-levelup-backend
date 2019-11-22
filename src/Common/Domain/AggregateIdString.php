<?php

namespace Common\Domain;

use Assert\Assertion;

class AggregateIdString implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const INVALID_ID = "Ist keine gültige ID: ";
    const INVALID_SIZE = "Hat mehr Zeichen als die erlaubten " . self::MAX_CHARS . ": ";

    const MAX_CHARS = 30;

    protected $id;

    /** @return static */
    public static function fromString(string $id): self {
        Assertion::string($id, 0, self::INVALID_ID . $id);
        Assertion::maxLength($id, self::MAX_CHARS, self::INVALID_SIZE . $id);

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