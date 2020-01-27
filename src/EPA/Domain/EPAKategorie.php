<?php

namespace EPA\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class EPAKategorie implements EPAElement, DDDValueObject
{
    use DefaultValueObjectComparison;

    const INVALID = "Ist keine gültige ID für eine EPA-Kategorie: ";

    private int $nummer;

    public static function fromInt(int $value): self {
        Assertion::integerish($value, self::INVALID);
        Assertion::inArray(
            $value,
            array_keys(EPAKonstanten::EBENE_1 + EPAKonstanten::EBENE_2),
            self::INVALID . $value
        );

        $object = new self();
        $object->nummer = $value;

        return $object;
    }

//    private static function getEPAStruktur(): array {
//        $resultArray = [];
//        foreach (array_keys(EPAKonstanten::EPAS) as $epaInt) {
//            $epa = EPA::fromInt($epaInt);
//            if ($epa->getParent()->getParent()) {
//                $resultArray
//                [$epa->getParent()->getParent()->getValue()][$epa->getParent()->getValue()][$epa->getValue()] = $epa;
//            } else {
//                $resultArray
//                [$epa->getParent()->getValue()][$epa->getValue()] = $epa;
//            }
//        }
//
//        return $resultArray;
//    }

    /** @return EPAElement[] */
    public static function getEPAStrukturFlach(): array {
        $returnArray = [];
        foreach (array_keys(EPAKonstanten::EBENE_1) as $epaKatInt) {
            $returnArray[] = EPAKategorie::fromInt($epaKatInt);
        }
        foreach (array_keys(EPAKonstanten::EBENE_2) as $epaKatInt) {
            $returnArray[] = EPAKategorie::fromInt($epaKatInt);
        }
        foreach (array_keys(EPAKonstanten::EPAS) as $epaInt) {
            $returnArray[] = EPA::fromInt($epaInt);
        }

        return $returnArray;
    }

    public function getNummer(): int {
        return $this->nummer;
    }

    public function getBeschreibung(): string {
        return isset(EPAKonstanten::EBENE_1[$this->nummer])
            ? EPAKonstanten::EBENE_1[$this->nummer]
            :
            EPAKonstanten::EBENE_2[$this->nummer];
    }

    public function getParent(): ?self {
        $isSubCategory = $this->nummer % 100 >= 10;
        if (!$isSubCategory) {
            return NULL;
        }

        return self::fromInt((int) floor($this->nummer / 100) * 100);
    }

    public function istBlatt(): bool {
        return FALSE;
    }
}