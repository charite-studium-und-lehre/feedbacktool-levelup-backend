<?php

namespace Pruefung\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class PruefungsFormat implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const MC = 10;

    const PTM = 20;

    const OSCE = 30;

    const FORMAT_KONSTANTEN = [
        self::MC,
        self::PTM,
        self::OSCE,
    ];

    const FORMAT_TITEL = [
        self::MC   => "MC-Test",
        self::PTM  => "PTM",
        self::OSCE => "Stationsprüfung",
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

    public function getValue(): int {
        return $this->value;

    }

    public function getTitel(): string {
        return self::FORMAT_TITEL[$this->value];
    }

}