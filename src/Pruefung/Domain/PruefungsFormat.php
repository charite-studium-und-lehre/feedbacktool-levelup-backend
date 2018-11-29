<?php

namespace Pruefung\Domain;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

class Pruefungsformat
{
    use DefaultValueObjectComparison;

    const MC_FORMAT = 10;

    const PTM_FORMAT = 20;

    const OSCE_FORMAT = 30;


    const FORMAT_KONSTANTEN = [
        self::MC_FORMAT,
        self::PTM_FORMAT,
        self::OSCE_FORMAT,
    ];

    const FORMAT_TITEL = [
        self::MC_FORMAT => "MC-Test",
        self::PTM_FORMAT => "PTM",
        self::OSCE_FORMAT => "Stationsprüfung",
    ];


    const INVALID_PRUEFUNGSFORMAT = "Kein gültiges Prüfungsformat: ";

    /** @var int */
    private $value;

    public static function fromConst(int $value): self {

        Assertion::inArray($value, self::FORMAT_KONSTANTEN, self::INVALID_PRUEFUNGSFORMAT . $value);

        $object = new self();
        $object->value = $value;

        return $object;
    }

    public function getValue() : int {
        return $this->value;

    }

    public function getTitel() : string {
        return self::FORMAT_TITEL[$this->value];
    }

}