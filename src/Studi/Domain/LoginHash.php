<?php

namespace Studi\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

final class LoginHash implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const MIN_LENGTH = 64;
    const MAX_LENGTH = 100;

    const UNGUELTIG = "Scheint kein Login-Hash zu sein: ";

    private string $value;

    public static function fromString(string $value): self {
        Assertion::String($value, self::UNGUELTIG . $value);
        Assertion::base64($value, self::UNGUELTIG . $value);
        Assertion::false(strstr($value, "'"), self::UNGUELTIG . $value);
        Assertion::false(strstr($value, '"'), self::UNGUELTIG . $value);
        Assertion::minLength($value, self::MIN_LENGTH, self::UNGUELTIG . $value);
        Assertion::maxLength($value, self::MAX_LENGTH, self::UNGUELTIG . $value);

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