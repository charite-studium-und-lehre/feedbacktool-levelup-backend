<?php

namespace EPA\Domain\SelbstBewertung;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class SelbstBewertungsTyp implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const GEMACHT = 10;
    const ZUTRAUEN = 20;

    const INVALID = "Ist kein SelbstBewertungsTyp: ";

    /** @var int */
    private $value;

    public static function fromInt(string $value): self {
        $intVal = (int) $value;
        Assertion::integerish($intVal, self::INVALID . $value);
        Assertion::inArray($intVal, [self::GEMACHT, self::ZUTRAUEN], self::INVALID . $value);
        $object = new self();
        $object->value = $intVal;

        return $object;
    }

    public static function getGemachtObject(): self {
        return self::fromInt(self::GEMACHT);
    }

    public static function getZutrauenObject(): self {
        return self::fromInt(self::ZUTRAUEN);
    }

    public function getValue(): int {
        return $this->value;
    }

    public function istGemacht(): bool {
        return $this->value == self::GEMACHT;
    }
    public function istZutrauen(): bool {
        return !$this->istGemacht();
    }

}