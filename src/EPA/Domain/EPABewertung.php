<?php

namespace EPA\Domain;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

class EPABewertung
{
    use DefaultValueObjectComparison;

    const BEWERTUNG_MIN = 0;
    const BEWERTUNG_MAX = 5;

    const INVALID = "Bewertungen sind nur zwischen 1 und 6 möglich!";

    const BEWERTUNG_BESCHREIBUNG = [
        0 => "0 - keine Ausführung",
        1 => "1 - gemeinsam mit dem Arzt",
        2 => "2 - unter Beobachtung des Arztes",
        3 => "3 - eigenständig, alles wird nachgeprüft (Arzt auf Station)",
        4 => "4 - eigenständig, Wichtiges wird nachgeprüft (Arzt auf Station)",
        5 => "5 - eigenständig, Wichtiges wird nachgeprüft (Arzt nur telefonisch erreichbar)",
    ];

    private int $bewertung;

    private EPA $epa;

    public function getEpa(): EPA {
        return $this->epa;
    }

    public static function fromValues(string $bewertungsInt, EPA $epa): self {
        Assertion::integerish($bewertungsInt, self::INVALID);
        Assertion::between($bewertungsInt, self::BEWERTUNG_MIN, self::BEWERTUNG_MAX, self::INVALID);

        $object = new self();
        $object->epa = $epa;
        $object->bewertung = $bewertungsInt;

        return $object;
    }

    public function setzeStufe(int $stufe): self {
        $stufe = min($stufe, self::BEWERTUNG_MAX);
        $stufe = max($stufe, self::BEWERTUNG_MIN);
        return self::fromValues($stufe, $this->epa);
    }

    public function erhoeheStufe(): self {
        return self::fromValues(
            min($this->bewertung + 1, self::BEWERTUNG_MAX),
            $this->epa
            );
    }

    public function vermindereStufe(): self {
        return self::fromValues(
            max($this->bewertung - 1, self::BEWERTUNG_MIN),
            $this->epa
        );
    }

    public function getBewertungInt(): int {
        return $this->bewertung;
    }

    public function getBeschreibung(): string {
        return self::BEWERTUNG_BESCHREIBUNG[$this->bewertung];
    }
}