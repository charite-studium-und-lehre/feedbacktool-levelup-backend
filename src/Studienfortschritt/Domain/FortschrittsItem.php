<?php

namespace Studienfortschritt\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;
use Exception;
use Pruefung\Domain\Pruefung;
use StudiPruefung\Domain\StudiPruefungsId;

class FortschrittsItem implements DDDValueObject
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

    const FORTSCHRITT_KUERZEL_ZU_CODE = [
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
        "voraus_sem10" => 310, // das ergibt sich direkt aus voraus_sem9

        "MC-Sem1" => 401,
        "MC-Sem2" => 402,
        "MC-Sem3" => 403,
        "MC-Sem4" => 404,
        "MC-Sem5" => 405,
        "MC-Sem6" => 406,
        "MC-Sem7" => 407,
        "MC-Sem8" => 408,
        "MC-Sem9" => 409,

        "stat_prfg_sem2_vorklinik" => 501,
        "stat_prfg_sem2_klinik"    => 502,
        "stat_prfg_sem4_vorklinik" => 503,
        "stat_prfg_sem4_klinik"    => 504,
        "osce_sem9_klinik"         => 509,

    ];

    const IMPLIZIERT = [
        201 => [401],
        202 => [402, 501, 502],
        203 => [403, 20, 30],
        204 => [404, 503, 504],
        205 => [405],
        206 => [406],
        207 => [407],
        208 => [408],
        209 => [409, 509],

        309 => [310],  // wer 309 hat, hat immer auch 310
    ];

    /** @var int */
    private $code;

    /** @var ?StudiPruefungsId */
    private $studiPruefungsId;

    public static function fromCode(int $code, ?StudiPruefungsId $studiPruefungsId = NULL): self {
        Assertion::inArray($code, self::FORTSCHRITT_KUERZEL_ZU_CODE, self::UNGUELTIG . $code);
        if ($code < 100 && $studiPruefungsId) {
            throw new InvalidArgumentException("Ein Meilenstein kann keinen Bezug zu einer Prüfung haben");
        }

        $object = new self();
        $object->code = $code;
        $object->studiPruefungsId = $studiPruefungsId;

        return $object;
    }

    public static function fromPruefung(Pruefung $pruefung, StudiPruefungsId $studiPruefungsId): ?self {
        $pruefungsFormat = $pruefung->getFormat();

        if ($pruefungsFormat->isMc()) {
            return FortschrittsItem::fromCode($pruefungsFormat->getValue() - 10 + 400, $studiPruefungsId);
        }
        if ($pruefungsFormat->isStation()) {
            return FortschrittsItem::fromCode($pruefungsFormat->getValue() - 30 + 1 + 500, $studiPruefungsId);
        }

        return NULL;

    }

    public static function fromKuerzel(string $value): self {
        Assertion::keyIsset(self::FORTSCHRITT_KUERZEL_ZU_CODE, $value, self::UNGUELTIG_KUERZEL . $value);

        return self::fromCode(self::FORTSCHRITT_KUERZEL_ZU_CODE[$value]);
    }

    public function mitStudiPruefungsId(StudiPruefungsId $studiPruefungsId): self {
        $newObject = clone $this;
        $newObject->studiPruefungsId = $studiPruefungsId;

        return $newObject;
    }

    public function getCode() {
        return $this->code;
    }

    public function getKuerzel() {
        return array_flip(self::FORTSCHRITT_KUERZEL_ZU_CODE)[$this->code];
    }

    public function getStudiPruefungsId(): ?StudiPruefungsId {
        return $this->studiPruefungsId;
    }

    public function getTitel() {
        if (isset(self::MEILENSTEINE[$this->code])) {
            return self::MEILENSTEINE[$this->code];
        }
        $fachsemester = $this->getFachsemester();
        if ($this->code > 100 && $this->code <= 110) {
            return "Anwesenheit Sem. $fachsemester";
        }
        if ($this->code > 200 && $this->code <= 210) {
            return "Abgeschlossen Sem. $fachsemester";
        }
        if ($this->code > 300 && $this->code <= 310) {
            return "Voraussetzung erfüllt Sem. $fachsemester";
        }
        if ($this->code > 400 && $this->code <= 410) {
            return "MC-Prüfung Sem. $fachsemester";
        }
        if ($this->code > 500 && $this->code <= 510) {
            if ($this->code == 501) {
                return "Mündliche Prüfung Sem. 2 (Vorklinik)";
            }
            if ($this->code == 502) {
                return "Praktische Prüfung Sem. 2 (Klinik)";
            }
            if ($this->code == 503) {
                return "Mündliche Prüfung Sem. 4 (Vorklinik)";
            }
            if ($this->code == 504) {
                return "Praktische Prüfung Sem. 4 (Klinik)";
            }

            return "Stationen-Prüfung Sem. $fachsemester";
        }
    }

    public function alleTitelNachCode(): array {
        $alleTitel = [];
        foreach (self::FORTSCHRITT_KUERZEL_ZU_CODE as $code) {
            $alleTitel[$code] = FortschrittsItem::fromCode($code)->getTitel();
        }

        return $alleTitel;
    }

    public function getFachsemester(): int {
        switch ($this->code) {
            case 10:
                return 6;
            case 20:
                return 3;
            case 30:
                return 3;
            case 40:
                return 4;
            case 50:
                return 6;
            case 60:
                return 10;
            case 70:
                return 4;
            case 501:
                return 2;
            case 502:
                return 2;
            case 503:
                return 4;
            case 504:
                return 4;
        }
        if ($this->code > 100) {
            return $this->code % 100;
        }
        throw new Exception("Fachsemester unbekannt für Code " . $this->code);
    }

    public function __toString(): string {
        return (string) $this->code;
    }

    /** @return FortschrittsItem[] */
    public function getImplizierteFortschrittsItems(): array {
        $impliziteFortschrittsItems = [];
        if (array_key_exists($this->code, self::IMPLIZIERT)) {
            foreach (self::IMPLIZIERT[$this->code] as $fortschrittsItemCode) {
                $impliziteFortschrittsItems[] = FortschrittsItem::fromCode($fortschrittsItemCode);
            }
        }

        return $impliziteFortschrittsItems;
    }

    public function getPruefungsTyp(): ?string {
        if ($this->code >= 400 && $this->code < 500) {
            return "mc";
        }
        if ($this->code >= 500 && $this->code < 600) {
            return "station";
        }

        return NULL;
    }

}