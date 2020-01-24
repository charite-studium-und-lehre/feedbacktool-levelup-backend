<?php

namespace Pruefung\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;
use LevelUpCommon\Domain\Zeitsemester;

class PruefungsPeriode implements DDDValueObject
{
    use DefaultValueObjectComparison;

    private Zeitsemester $zeitsemester;

    private ?PruefungsUnterPeriode $unterPeriode;

    public static function fromZeitsemester(Zeitsemester $zeitsemester): self {
        return self::fromZeitsemesterUndPeriode($zeitsemester);
    }

    public static function fromZeitsemesterUndPeriode(
        Zeitsemester $zeitsemester,
        ?PruefungsUnterPeriode $pruefungsZeitraum = NULL
    ): self {
        $object = new self();
        $object->zeitsemester = $zeitsemester;
        $object->unterPeriode = $pruefungsZeitraum;

        return $object;
    }

    public static function fromInt(string $value): PruefungsPeriode {
        Assertion::integerish($value);
        if ($value < 100_000) {
            $value *= 10;
        }

        return self::fromZeitsemesterUndPeriode(
            Zeitsemester::fromStandardInt($value / 10),
            ($value % 10) ? PruefungsUnterPeriode::fromInt($value % 10) : NULL
        );
    }

    public function getZeitsemester(): Zeitsemester {
        return $this->zeitsemester;
    }

    public function getUnterPeriode(): ?PruefungsUnterPeriode {
        return $this->unterPeriode;
    }

    public function __toString(): string {
        $returnString = $this->zeitsemester->getStandardString();
        if ($this->unterPeriode) {
            $returnString .= "-" . (string) $this->unterPeriode;
        }

        return "$returnString";
    }

    public function toInt(): int {
        $value = $this->zeitsemester->getStandardInt();
        if ($this->unterPeriode) {
            $value *= 10;
            $value += $this->unterPeriode->getValue();
        }

        return $value;
    }

    public function getPeriodeBeschreibung(): string {
        $returnString = $this->zeitsemester->getStandardStringLesbar();
        if ($this->unterPeriode) {
            $returnString .= " (Prüfungszeitraum " . $this->unterPeriode . ")";
        }

        return $returnString;
    }

    public function getPeriodeBeschreibungKurz(): string {
        $returnString = "";
        if ($this->unterPeriode) {
            $returnString .= " (" . $this->unterPeriode . ". Zeitraum)";
        }

        return $returnString;
    }
}