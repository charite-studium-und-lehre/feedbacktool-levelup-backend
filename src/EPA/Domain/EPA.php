<?php

namespace EPA\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class EPA implements EPAElement, DDDValueObject
{
    use DefaultValueObjectComparison;

    const INVALID = "Ist keine gültige ID für eine EPA: ";

    /** @var int */
    private $nummer;

    public static function fromInt(string $nummer): self {
        $intVal = (int) $nummer;
        Assertion::integerish($intVal, self::INVALID . $nummer);
        Assertion::inArray(
            $intVal,
            array_keys(EPAKonstanten::EPAS),
            self::INVALID . $nummer);
        $object = new self();
        $object->nummer = $intVal;

        return $object;
    }

    public function getNummer(): int {
        return $this->nummer;
    }

    public function getBeschreibung(): string {
        return EPAKonstanten::EPAS[$this->nummer];
    }

    public function getParent(): EPAKategorie {
        return EPAKategorie::fromInt(floor($this->nummer / 10) * 10);
    }

    public function istBlatt(): bool {
        return TRUE;
    }
}