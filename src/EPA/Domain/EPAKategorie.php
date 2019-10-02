<?php

namespace EPA\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class EPAKategorie implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const INVALID = "Ist keine gültige ID für eine EPA-Kategorie: ";

    /** @var int */
    private $value;

    public static function fromInt(string $value): self {
        $intVal = (int) $value;
        Assertion::integerish($intVal, self::INVALID);
        Assertion::inArray(
            $intVal,
            array_keys(EPAKonstanten::EBENE_1 + EPAKonstanten::EBENE_2),
            self::INVALID . $value
        );

        $object = new self();
        $object->value = $intVal;

        return $object;
    }

    public static function getEPAStruktur(): array {
        $resultArray = [];
        foreach (array_keys(EPAKonstanten::EPAS) as $epaInt) {
            $epa = EPA::fromInt($epaInt);
            if ($epa->getParent()->getParent()) {
                $resultArray
                [$epa->getParent()->getParent()->getValue()][$epa->getParent()->getValue()][$epa->getValue()] = $epa;
            } else {
                $resultArray
                [$epa->getParent()->getValue()][$epa->getValue()] = $epa;
            }
        }

        return $resultArray;
    }

    public function getValue(): int {
        return $this->value;
    }

    public function getBeschreibung(): string {
        return isset(EPAKonstanten::EBENE_1[$this->value])
            ? EPAKonstanten::EBENE_1[$this->value]
            :
            EPAKonstanten::EBENE_2[$this->value];
    }

    public function getParent(): ?self {
        $isSubCategory = $this->value % 100 >= 10;
        if (!$isSubCategory) {
            return NULL;
        }

        return self::fromInt(floor($this->value / 100) * 100);
    }

}