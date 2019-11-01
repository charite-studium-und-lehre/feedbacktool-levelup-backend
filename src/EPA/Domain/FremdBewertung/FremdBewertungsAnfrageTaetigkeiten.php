<?php

namespace EPA\Domain\FremdBewertung;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class FremdBewertungsAnfrageTaetigkeiten implements DDDValueObject
{
    const MIN_LENGTH = 5;
    const MAX_LENGTH = 2000;
    const UNGUELTIG = "Der Text der Tätigkeiten / Kurs ist ungültig: : ";

    use DefaultValueObjectComparison;

    /** @var string */
    private $value;

    public static function fromString(string $value): self {
        Assertion::String($value, self::UNGUELTIG . $value);
        Assertion::minLength($value, self::MIN_LENGTH, self::UNGUELTIG . $value);
        Assertion::maxLength($value, self::MAX_LENGTH, self::UNGUELTIG . $value);

        $object = new self();
        $object->value = $value;

        return $object;
    }

    public function getValue(): string {
        return $this->value;
    }


}