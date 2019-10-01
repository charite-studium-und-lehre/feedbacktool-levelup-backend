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

    /** @var int */
    private $bewertung;

    /** @var epa */
    private $epa;



    public static function fromInt(string $bewertung): self {
        Assertion::integerish($bewertung, self::INVALID);
        Assertion::between($bewertung, self::BEWERTUNG_MIN, self::BEWERTUNG_MAX, self::INVALID);

        $object = new self();
        $object->bewertung = $bewertung;

        return $object;
    }

    public function erhoeheStufe(): self {
        return self::fromInt(min($this->bewertung + 1, self::BEWERTUNG_MAX));
    }

    public function vermindereStufe(): self {
        return self::fromInt(max($this->bewertung - 1, self::BEWERTUNG_MIN));
    }

    public function getBewertung(): int {
        return $this->bewertung;
    }

    public function getBeschreibung(): string {
        return self::BEWERTUNG_BESCHREIBUNG[$this->bewertung];
    }

}