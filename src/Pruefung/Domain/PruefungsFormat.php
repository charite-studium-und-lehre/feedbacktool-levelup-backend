<?php

namespace Pruefung\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class PruefungsFormat implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const MC_SEM1 = 11;
    const MC_SEM2 = 12;
    const MC_SEM3 = 13;
    const MC_SEM4 = 14;
    const MC_SEM5 = 15;
    const MC_SEM6 = 16;
    const MC_SEM7 = 17;
    const MC_SEM8 = 18;
    const MC_SEM9 = 19;
    const MC_SEM10 = 20;

    const PTM = 50;

    const STATION_TEIL1_VORKLINIK = 30;
    const STATION_TEIL1_KLINIK = 31;
    const STATION_TEIL2 = 32;
    const STATION_TEIL3 = 33;

    const FORMAT_KONSTANTEN = [
        self::MC_SEM1,
        self::MC_SEM2,
        self::MC_SEM3,
        self::MC_SEM4,
        self::MC_SEM5,
        self::MC_SEM6,
        self::MC_SEM7,
        self::MC_SEM8,
        self::MC_SEM9,
        self::MC_SEM10,
        self::PTM,
        self::STATION_TEIL1_VORKLINIK,
        self::STATION_TEIL1_KLINIK,
        self::STATION_TEIL2,
        self::STATION_TEIL3,
    ];

    const MC_KONSTANTEN_NACH_FACHSEMESTER = [
        1  => self::MC_SEM1,
        2  => self::MC_SEM2,
        3  => self::MC_SEM3,
        4  => self::MC_SEM4,
        5  => self::MC_SEM5,
        6  => self::MC_SEM6,
        7  => self::MC_SEM7,
        8  => self::MC_SEM8,
        9  => self::MC_SEM9,
        10 => self::MC_SEM10,
    ];

    const FORMAT_TITEL = [
        self::MC_SEM1                 => "MC-Test Sem.1",
        self::MC_SEM2                 => "MC-Test Sem.2",
        self::MC_SEM3                 => "MC-Test Sem.3",
        self::MC_SEM4                 => "MC-Test Sem.4",
        self::MC_SEM5                 => "MC-Test Sem.5",
        self::MC_SEM6                 => "MC-Test Sem.6",
        self::MC_SEM7                 => "MC-Test Sem.7",
        self::MC_SEM8                 => "MC-Test Sem.8",
        self::MC_SEM9                 => "MC-Test Sem.9",
        self::MC_SEM10                => "MC-Test Sem.10",
        self::PTM                     => "PTM",
        self::STATION_TEIL1_VORKLINIK => "Stationsprüfung Teil1 Vorklinik",
        self::STATION_TEIL1_KLINIK    => "Stationsprüfung Teil1 Klinik",
        self::STATION_TEIL2           => "Stationsprüfung Teil2",
        self::STATION_TEIL3           => "Stationsprüfung Teil3",
    ];

    const FORMAT_CODE = [
        self::MC_SEM1                 => "MC-Sem1",
        self::MC_SEM2                 => "MC-Sem2",
        self::MC_SEM3                 => "MC-Sem3",
        self::MC_SEM4                 => "MC-Sem4",
        self::MC_SEM5                 => "MC-Sem5",
        self::MC_SEM6                 => "MC-Sem6",
        self::MC_SEM7                 => "MC-Sem7",
        self::MC_SEM8                 => "MC-Sem8",
        self::MC_SEM9                 => "MC-Sem9",
        self::MC_SEM10                => "MC-Sem10",
        self::PTM                     => "PTM",
        self::STATION_TEIL1_VORKLINIK => "Stat-Teil1 VK",
        self::STATION_TEIL1_KLINIK    => "Stat-Teil1 K",
        self::STATION_TEIL2           => "Stat-Teil2",
        self::STATION_TEIL3           => "Stat-Teil3",
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

    public static function getMC(int $fachsemester): PruefungsFormat {
        return self::fromConst(self::MC_KONSTANTEN_NACH_FACHSEMESTER[$fachsemester]);
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