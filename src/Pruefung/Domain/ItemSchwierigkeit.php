<?php

namespace Pruefung\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;
use Exception;

class ItemSchwierigkeit implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const SCHWIERIGKEIT_LEICHT = 10;
    const SCHWIERIGKEIT_NORMAL = 20;
    const SCHWIERIGKEIT_SCHWER = 30;

    const ALLE_SCHWIERIGKEITEN = [
        self::SCHWIERIGKEIT_LEICHT,
        self::SCHWIERIGKEIT_NORMAL,
        self::SCHWIERIGKEIT_SCHWER,
    ];

    private int $const;

    public static function fromConst(string $const): self {
        Assertion::integerish($const);
        $const = (int) $const;
        Assertion::inArray($const, self::ALLE_SCHWIERIGKEITEN);

        $object = new self();
        $object->const = $const;

        return $object;
    }

    public static function getLeicht(): self {
        return self::fromConst(self::SCHWIERIGKEIT_LEICHT);
    }

    public static function getNormal(): self {
        return self::fromConst(self::SCHWIERIGKEIT_NORMAL);
    }

    public static function getSchwer(): self {
        return self::fromConst(self::SCHWIERIGKEIT_SCHWER);
    }

    public function getConst(): int {
        return $this->const;
    }

    public function isLeicht(): bool {
        return $this->const == self::SCHWIERIGKEIT_LEICHT;
    }

    public function isNormal(): bool {
        return $this->const == self::SCHWIERIGKEIT_NORMAL;
    }

    public function isSchwer(): bool {
        return $this->const == self::SCHWIERIGKEIT_SCHWER;
    }

    public function getSchwierigkeitText(): string {
        switch ($this->const) {
            case self::SCHWIERIGKEIT_LEICHT:
                return "leicht";
            case self::SCHWIERIGKEIT_NORMAL:
                return "normal";
            case self::SCHWIERIGKEIT_SCHWER:
                return "schwer";
        }
        throw new Exception("Unbekannte Schwierigkeit: " . $this->const);
    }

}