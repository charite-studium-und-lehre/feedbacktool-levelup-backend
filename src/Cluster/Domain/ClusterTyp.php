<?php

namespace Cluster\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class ClusterTyp implements DDDValueObject
{
    use DefaultValueObjectComparison;

    private const TYP_ID_FACH = 100;
    private const TYP_ID_ORGANSYSTEM = 200;

    private const TYP_ID_STATIONS_FACH = 300;
    private const TYP_ID_STATION_MODUL = 310;
    private const TYP_ID_STATION_WISSENS_TYP = 320;

    private const TYP_ID_MODUL = 500;
    private const TYP_VERANSTALTUNGS_NUMMER = 510;
    private const TYP_LERNZIEL_NUMMER = 520;
    private const TYP_FRAGEN_NUMMER = 530;

    private const ALLE_KONSTANTEN = [
        self::TYP_ID_FACH, self::TYP_ID_ORGANSYSTEM, self::TYP_ID_MODUL,
        self::TYP_ID_STATIONS_FACH, self::TYP_ID_STATION_MODUL, self::TYP_ID_STATION_WISSENS_TYP,
        self::TYP_VERANSTALTUNGS_NUMMER, self::TYP_LERNZIEL_NUMMER, self::TYP_FRAGEN_NUMMER
    ];

    const INVALID = "Der Clustertyp ist nicht bekannt: ";

    private int $const;

    public static function fromConst(int $const): self {
        Assertion::inArray($const, self::ALLE_KONSTANTEN, self::INVALID . $const);
        $object = new self();
        $object->const = $const;

        return $object;
    }

    public static function getFachTyp(): ClusterTyp {
        return self::fromConst(self::TYP_ID_FACH);
    }

    public static function getOrgansystemTyp(): ClusterTyp {
        return self::fromConst(self::TYP_ID_ORGANSYSTEM);
    }

    public static function getModulTyp(): ClusterTyp {
        return self::fromConst(self::TYP_ID_MODUL);
    }


    public static function getStationsFachTyp(): ClusterTyp {
        return self::fromConst(self::TYP_ID_STATIONS_FACH);
    }

    public static function getStationsModulTyp(): ClusterTyp {
        return self::fromConst(self::TYP_ID_STATION_MODUL);
    }

    public static function getStationsWissensTyp(): ClusterTyp {
        return self::fromConst(self::TYP_ID_STATION_WISSENS_TYP);
    }

    public function getConst(): int {
        return $this->const;
    }

    public function isFachTyp(): bool {
        return $this->getConst() === self::TYP_ID_FACH;
    }

    public function isOrgansystemTyp(): bool {
        return $this->getConst() === self::TYP_ID_ORGANSYSTEM;
    }

    public function isModulTyp(): bool {
        return $this->getConst() === self::TYP_ID_MODUL;
    }

    public function isStationsFachTyp(): bool {
        return $this->getConst() === self::TYP_ID_STATIONS_FACH;
    }

    public function isStationsModulTyp(): bool {
        return $this->getConst() === self::TYP_ID_STATION_MODUL;
    }

    public function isStationsWissenTyp(): bool {
        return $this->getConst() === self::TYP_ID_STATION_WISSENS_TYP;
    }

}