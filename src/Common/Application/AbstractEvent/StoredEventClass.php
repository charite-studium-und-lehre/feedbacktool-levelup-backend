<?php

namespace Common\Application\AbstractEvent;

use Assert\Assertion;

class StoredEventClass
{
    const CLASS_NOT_EXISTS = "Die als String gegebene Stored-DomainEvent-Klasse muss existieren!";

    private string $value;

    public static function fromString(string $eventClassName): self {
        Assertion::classExists($eventClassName, self::CLASS_NOT_EXISTS);

        $object = new self();
        $object->value = $eventClassName;

        return $object;
    }

    public function getValue() {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value;
    }
}
