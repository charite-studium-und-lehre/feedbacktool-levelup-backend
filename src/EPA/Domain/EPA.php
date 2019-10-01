<?php

namespace EPA\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class EPA implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const INVALID = "Ist keine gültige ID für eine EPA: ";

    /** @var int */
    private $value;

    public static function fromInt(string $value): self {
        $intVal = (int) $value;
        Assertion::integerish($intVal, self::INVALID . $value);
        Assertion::inArray(
            $intVal,
            array_keys(EPAKonstanten::EPAS),
            self::INVALID . $value);
        $object = new self();
        $object->value = $intVal;

        return $object;
    }

    public function getValue(): int {
        return $this->value;
    }

    public function getBeschreibung(): string {
        return EPAKonstanten::EPAS[$this->value];
    }

    public function getParent(): EPAKategorie {
        return EPAKategorie::fromInt(floor($this->value / 10) * 10);
    }
}