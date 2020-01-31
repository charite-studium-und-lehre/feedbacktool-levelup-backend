<?php

namespace Pruefung\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;
use Exception;

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

    const STATION_TEIL1_VORKLINIK_SEM2 = 30;
    const STATION_TEIL1_KLINIK_SEM2 = 31;
    const STATION_TEIL2_SEM4 = 32;
    const STATION_TEIL3_SEM4 = 33;
    const STATION_OSCE_SEM9 = 39;

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
        self::STATION_TEIL1_VORKLINIK_SEM2,
        self::STATION_TEIL1_KLINIK_SEM2,
        self::STATION_TEIL2_SEM4,
        self::STATION_TEIL3_SEM4,
        self::STATION_OSCE_SEM9,
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

    const FORMAT_TITEL_LANG = [
        self::MC_SEM1                      => "MC-Test Semester 1",
        self::MC_SEM2                      => "MC-Test Semester 2",
        self::MC_SEM3                      => "MC-Test Semester 3",
        self::MC_SEM4                      => "MC-Test Semester 4",
        self::MC_SEM5                      => "MC-Test Semester 5",
        self::MC_SEM6                      => "MC-Test Semester 6",
        self::MC_SEM7                      => "MC-Test Semester 7",
        self::MC_SEM8                      => "MC-Test Semester 8",
        self::MC_SEM9                      => "MC-Test Semester 9",
        self::MC_SEM10                     => "MC-Test Semester 10",
        self::PTM                          => "PTM",
        self::STATION_TEIL1_VORKLINIK_SEM2 => "Mündliche Stationsprüfung Semester 2 (Vorklinik)",
        self::STATION_TEIL1_KLINIK_SEM2    => "Praktische Stationsprüfung Semester 2 (Klinik)",
        self::STATION_TEIL2_SEM4           => "Mündliche Stationsprüfung Semester 4 (Vorklinik)",
        self::STATION_TEIL3_SEM4           => "Praktische Stationsprüfung Semester 4 (Klinik)",
        self::STATION_OSCE_SEM9            => "OSCE-Prüfung Semester 9",
    ];

    const FORMAT_TITEL_KURZ = [
        self::MC_SEM1                      => "MC-Test Semester 1",
        self::MC_SEM2                      => "MC-Test Semester 2",
        self::MC_SEM3                      => "MC-Test Semester 3",
        self::MC_SEM4                      => "MC-Test Semester 4",
        self::MC_SEM5                      => "MC-Test Semester 5",
        self::MC_SEM6                      => "MC-Test Semester 6",
        self::MC_SEM7                      => "MC-Test Semester 7",
        self::MC_SEM8                      => "MC-Test Semester 8",
        self::MC_SEM9                      => "MC-Test Semester 9",
        self::MC_SEM10                     => "MC-Test Semester 10",
        self::PTM                          => "PTM",
        self::STATION_TEIL1_VORKLINIK_SEM2 => "Mündliche Prüfung 2. FS",
        self::STATION_TEIL1_KLINIK_SEM2    => "Praktische Prüfung 2. FS",
        self::STATION_TEIL2_SEM4           => "Mündliche Prüfung 4. FS",
        self::STATION_TEIL3_SEM4           => "Praktische Prüfung 4. FS",
        self::STATION_OSCE_SEM9            => "OSCE 9. FS",
    ];

    const FORMAT_CODE = [
        self::MC_SEM1                      => "MC-Sem1",
        self::MC_SEM2                      => "MC-Sem2",
        self::MC_SEM3                      => "MC-Sem3",
        self::MC_SEM4                      => "MC-Sem4",
        self::MC_SEM5                      => "MC-Sem5",
        self::MC_SEM6                      => "MC-Sem6",
        self::MC_SEM7                      => "MC-Sem7",
        self::MC_SEM8                      => "MC-Sem8",
        self::MC_SEM9                      => "MC-Sem9",
        self::MC_SEM10                     => "MC-Sem10",
        self::PTM                          => "PTM",
        self::STATION_TEIL1_VORKLINIK_SEM2 => "Stat-1VK",
        self::STATION_TEIL1_KLINIK_SEM2    => "Stat-1K",
        self::STATION_TEIL2_SEM4           => "Stat-2",
        self::STATION_TEIL3_SEM4           => "Stat-3",
        self::STATION_OSCE_SEM9            => "Stat-9",
    ];

    const INVALID_PRUEFUNGSFORMAT = "Kein gültiges Prüfungsformat: ";

    private int $value;

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
        return self::fromConst(self::STATION_TEIL1_KLINIK_SEM2);
    }

    public static function getStationTeil1Vorklinik(): PruefungsFormat {
        return self::fromConst(self::STATION_TEIL1_VORKLINIK_SEM2);
    }

    public static function getStationTeil2(): PruefungsFormat {
        return self::fromConst(self::STATION_TEIL2_SEM4);
    }

    public static function getStationTeil3(): PruefungsFormat {
        return self::fromConst(self::STATION_TEIL3_SEM4);
    }

    public static function getStationOsceSem9(): PruefungsFormat {
        return self::fromConst(self::STATION_OSCE_SEM9);
    }

    public function getValue(): int {
        return $this->value;
    }

    public function getTitel(): string {
        return self::FORMAT_TITEL_LANG[$this->value];
    }

    public function getTitelKurz(): string {
        return self::FORMAT_TITEL_KURZ[$this->value];
    }

    public function getCode(): string {
        return self::FORMAT_CODE[$this->value];
    }

    public function isMc(): bool {
        return $this->getValue() >= self::MC_SEM1
            && $this->getValue() <= self::MC_SEM10;
    }

    public function isStation(): bool {
        return $this->getValue() >= self::STATION_TEIL1_VORKLINIK_SEM2
            && $this->getValue() <= self::STATION_OSCE_SEM9;
    }

    public function getStationsTyp(): ?string {
        if (!$this->isStation()) {
            return NULL;
        }
        if (in_array($this->getValue(), [30, 32])) {
            return "vorklinisch";
        }

        return "klinisch";
    }

    public function isPTM(): bool {
        return $this->getValue() == self::PTM;
    }

    public function hatBestandenWert(): bool {
        return $this->isPTM();
    }

    public function getFormatAbstrakt(): string {
        if ($this->isStation()) {
            return "station";
        } elseif ($this->isPTM()) {
            return "ptm";
        } elseif ($this->isMc()) {
            return "mc";
        }
        throw new Exception("Format nicht bekannt: " . $this->value);
    }

}