<?php

namespace LevelUpCommon\Domain;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;
use DateTime;
use DateTimeImmutable;

class Zeitsemester
{
    use DefaultValueObjectComparison;

    const SOSE = 1;

    const WISE = 2;

    const SEMESTER_STRING = [
        self::SOSE => "SoSe",
        self::WISE => "WiSe",
    ];

    const INVALID_SEMESTER = "Kein gültige Semesterbezeichnung: ";

    private int $halbjahr;

    private int $jahr;

    public static function fromString(string $zeitsemester): self {
        $invalidMessage = self::INVALID_SEMESTER . $zeitsemester;
        Assertion::length($zeitsemester, 8, $invalidMessage);

        $halbjahr = substr($zeitsemester, 0, 4);
        Assertion::inArray($halbjahr, self::SEMESTER_STRING, $invalidMessage);
        $jahr = (int) (substr($zeitsemester, 4, 4));

        $halbjahrConst = array_flip(self::SEMESTER_STRING)[$halbjahr];

        return self::fromInts($halbjahrConst, $jahr);
    }

    public static function fromInts(int $halbjahr, int $jahr): self {
        $invalidMessage = self::INVALID_SEMESTER . "$halbjahr-$jahr";
        Assertion::inArray($halbjahr, [self::SOSE, self::WISE]);
        Assertion::date((string) $jahr, "Y", $invalidMessage);
        Assertion::between($jahr, 2_000, 10_000, $invalidMessage);

        $object = new self();
        $object->halbjahr = $halbjahr;
        $object->jahr = $jahr;

        return $object;
    }

    public static function fromStandardInt(int $zeitsemesterInt): self {
        return self::fromInts($zeitsemesterInt % 10, $zeitsemesterInt / 10);
    }

    public static function createAktuellesZeitsemester(): Zeitsemester {
        $jetzt = new DateTimeImmutable();
        $jahr = (int) $jetzt->format("Y");
        $monat = (int) $jetzt->format("m");
        if ($monat < 4) {
            // WiSe des Vorjahres
            return self::fromInts(self::WISE, $jahr - 1);
        }
        if ($monat < 10) {
            // SoSe dieses Jahres
            return self::fromInts(self::SOSE, $jahr);
        }

        return self::fromInts(self::WISE, $jahr);

    }

    public function getStartDatum(): DateTime {
        if ($this->halbjahr == self::SOSE) {
            return new DateTime($this->jahr . "-04-01 00:00:00");
        } else {
            return new DateTime($this->jahr . "-10-01 00:00:00");
        }
    }

    public function getEndDatum(): DateTime {
        if ($this->halbjahr == self::SOSE) {
            return new DateTime($this->jahr . "-09-30 23:59:59");
        } else {
            return new DateTime(($this->jahr + 1) . "-03-31 23:59:59");
        }
    }

    /**
     * @return int
     */
    public function getJahr(): int {
        return $this->jahr;
    }

    /**
     * @return int
     */
    public function getHalbjahr(): int {
        return $this->halbjahr;
    }

    /** @return z.B. "WiSe2019 */
    public function getStandardString(): string {
        return self::SEMESTER_STRING[$this->halbjahr] . $this->jahr;
    }
    /** @return z.B. "WiSe 2019 */
    public function getStandardStringLesbar(): string {
        return self::SEMESTER_STRING[$this->halbjahr] . " " . $this->jahr;
    }

    /** z.B. 20192 für WiSe2019 */
    public function getStandardInt(): int {
        return $this->jahr * 10 + $this->getHalbjahr();
    }

    public function getCampusnetString(): string {
        $standardString = $this->getStandardString();

        if ($this->getHalbjahr() == self::SOSE) {
            return $standardString;
        }

        return $standardString . "_" . (($this->jahr % 100) + 1);

    }

    public function getNaechstesZeitsemester(): Zeitsemester {
        if ($this->halbjahr == self::WISE) {
            $neuesJahr = $this->jahr + 1;

            return Zeitsemester::fromInts(self::SOSE, $neuesJahr);
        } else {
            return Zeitsemester::fromInts(self::WISE, $this->jahr);
        }
    }

    public function getVorherigesZeitsemester(): Zeitsemester {
        if ($this->halbjahr == self::SOSE) {
            $neuesJahr = $this->jahr - 1;

            return Zeitsemester::fromInts(self::WISE, $neuesJahr);
        } else {
            return Zeitsemester::fromInts(self::SOSE, $this->jahr);
        }
    }
}