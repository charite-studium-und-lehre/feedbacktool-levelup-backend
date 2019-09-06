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

    const STATION_TEIL1_VORKLINIK = 30;
    const STATION_TEIL1_KLINIK = 31;
    const STATION_TEIL2 = 32;
    const STATION_TEIL3 = 33;

    const FORMAT_KONSTANTEN = [
        self::MC,
        self::PTM,
        self::STATION_TEIL1_VORKLINIK,
        self::STATION_TEIL1_KLINIK,
        self::STATION_TEIL2,
        self::STATION_TEIL3,
    ];

    const FORMAT_TITEL = [
        self::MC                      => "MC-Test",
        self::PTM                     => "PTM",
        self::STATION_TEIL1_VORKLINIK => "Stationsprüfung Teil1 Vorklinik",
        self::STATION_TEIL1_KLINIK    => "Stationsprüfung Teil1 Klinik",
        self::STATION_TEIL2           => "Stationsprüfung Teil2",
        self::STATION_TEIL3           => "Stationsprüfung Teil3",
    ];

    const FORMAT_CODE = [
        self::MC                      => "MC",
        self::PTM                     => "PTM",
        self::STATION_TEIL1_VORKLINIK => "Station Teil1 VK",
        self::STATION_TEIL1_KLINIK    => "Station Teil1 K",
        self::STATION_TEIL2           => "Station Teil2",
        self::STATION_TEIL3           => "Station Teil3",
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

    public static function getMC(): PruefungsFormat {
        return self::fromConst(self::MC);
    }
    public static function getPTM(): PruefungsFormat {
        return self::fromConst(self::PTM);
    }
    public static function getStationTeil1Klinik(): PruefungsFormat {
        return self::fromConst(self::STATION_TEIL1_KLINIK);
    }
    public static function getStationTeil1Vorklinik(): PruefungsFormat {
        return self::fromConst(self::STATION_TEIL1_VORKLINIK);
    }
    public static function getStationTeil2(): PruefungsFormat {
        return self::fromConst(self::STATION_TEIL2);
    }
    public static function getStationTeil3(): PruefungsFormat {
        return self::fromConst(self::STATION_TEIL3);
    }

    public function getValue(): int {
        return $this->value;

    }

    public function getTitel(): string {
        return self::FORMAT_TITEL[$this->value];
    }

    public function getCode(): string {
        return self::FORMAT_CODE[$this->value];
    }

}