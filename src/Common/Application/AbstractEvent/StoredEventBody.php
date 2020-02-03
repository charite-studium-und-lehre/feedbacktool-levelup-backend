<?php

namespace Common\Application\AbstractEvent;

use Assert\Assertion;

class StoredEventBody
{
    const MIN_LAENGE = 8;

    const MAX_LAENGE = 2_000;

    const INVALID_ZU_KURZ = "Der serialisierte DomainEvent-Body muss mindestens " . self::MIN_LAENGE
    . " Zeichen enthalten!";

    const INVALID_ZU_LANG = "Der serialisierte DomainEvent-Body darf maximal " . self::MAX_LAENGE
    . " Zeichen enthalten!";

    private string $value;

    public static function fromString(string $serializedEventBody): self {
        Assertion::minLength($serializedEventBody, self::MIN_LAENGE, self::INVALID_ZU_KURZ);
        Assertion::maxLength($serializedEventBody, self::MAX_LAENGE, self::INVALID_ZU_LANG);

        $object = new self();
        $object->value = $serializedEventBody;

        return $object;
    }

    public function getValue(): string {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value;
    }
}
