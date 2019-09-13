<?php

namespace StudiMeilenstein\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

final class Meilenstein implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const UNGUELTIG = "Der Meilenstein-Code existiert nicht: ";
    const UNGUELTIG_KUERZEL = "Das Meilenstein-Kürzel existiert nicht: ";

    const MEILENSTEINE = [
        10 => "Hausarbeit",
        20 => "Erste Hilfe",
        30 => "Pflegepraktikum",
        40 => "Famulatur-Reife",
        50 => "M1-Äquivalenz",
        60 => "M2-Voraussetzung",
        70 => "Stationenprüfung bestanden",

    ];

    const MEILENSTEINE_KUERZEL_ZU_CODE = [
        "hausarb_best" => 10,
        "erste_hilfe"  => 20,
        "pflege_prakt" => 30,
        "fam_reife"    => 40,
        "m1_eq"        => 50,
        "m2_vor"       => 60,
        "stat_prfg"    => 70,

        "anw_sem1" => 101,
        "anw_sem2" => 102,
        "anw_sem3" => 103,
        "anw_sem4" => 104,
        "anw_sem5" => 105,
        "anw_sem6" => 106,
        "anw_sem7" => 107,
        "anw_sem8" => 108,
        "anw_sem9" => 109,

        "best_sem1"  => 201,
        "best_sem2"  => 202,
        "best_sem3"  => 203,
        "best_sem4"  => 204,
        "best_sem5"  => 205,
        "best_sem6"  => 206,
        "best_sem7"  => 207,
        "best_sem8"  => 208,
        "best_sem9"  => 209,
        "best_sem10" => 210,

        "voraus_sem4"  => 304,
        "voraus_sem5"  => 305,
        "voraus_sem6"  => 306,
        "voraus_sem7"  => 307,
        "voraus_sem8"  => 308,
        "voraus_sem9"  => 309,

        "mc_sem1"  => 401,
        "mc_sem2"  => 402,
        "mc_sem3"  => 403,
        "mc_sem4"  => 404,
        "mc_sem5"  => 405,
        "mc_sem6"  => 406,
        "mc_sem7"  => 407,
        "mc_sem8"  => 408,
        "mc_sem9"  => 409,
        "mc_sem10" => 410,

        "stat_prfg_sem2" => 502,
        "stat_prfg_sem4" => 504,
        "stat_prfg_sem9" => 509,

    ];

    private $code;

    public static function fromCode(int $value): self {
        Assertion::inArray($value, self::MEILENSTEINE_KUERZEL_ZU_CODE, self::UNGUELTIG . $value);

        $object = new self();
        $object->code = $value;

        return $object;
    }

    public static function fromKuerzel(string $value): self {
        Assertion::keyIsset(self::MEILENSTEINE_KUERZEL_ZU_CODE, $value, self::UNGUELTIG_KUERZEL . $value);
        return self::fromCode(self::MEILENSTEINE_KUERZEL_ZU_CODE[$value]);
    }

    public function getCode() {
        return $this->code;
    }

    public function getKuerzel() {
        return array_flip(self::MEILENSTEINE_KUERZEL_ZU_CODE)[$this->code];
    }

    public function getTitel() {
        if (isset(self::MEILENSTEINE[$this->code])) {
            return self::MEILENSTEINE[$this->code];
        }
        $fachsemester = ($this->getCode() % 100);
        if ($this->code > 100 && $this->code <= 110) {
            return "Anwesenheit Sem. $fachsemester";
        }
        if ($this->code > 200 && $this->code <= 210) {
            return "Abgeschlossen Sem. $fachsemester";
        }
        if ($this->code > 300 && $this->code <= 310) {
            return "Voraussetzung erfüllt Sem. " .
                ($fachsemester < 9 ? $fachsemester : "9+10");
        }
        if ($this->code > 400 && $this->code <= 410) {
            return "MC-Prüfung Sem. $fachsemester";
        }
        if ($this->code > 500 && $this->code <= 510) {
            return "Stationen-Prüfung Sem. $fachsemester";
        }
    }

    public function alleTitelNachCode(): array {
        $alleTitel = [];
        foreach (self::MEILENSTEINE_KUERZEL_ZU_CODE as $code) {
            $alleTitel[$code] = Meilenstein::fromCode($code)->getTitel();
        }
        return $alleTitel;
    }

    public function getFachsemester(): int {
        switch ($this->code) {
            case 10: return 6;
            case 20: return 3;
            case 30: return 3;
            case 40: return 4;
            case 50: return 6;
            case 60: return 10;
            case 70: return 9;
        }
        if ($this->code > 100) {
            return $this->code % 100;
        }
        throw new \Exception("Fachsemester unbekannt für Code " . $this->code);
    }

    public function __toString(): string {
        return $this->code;
    }

}