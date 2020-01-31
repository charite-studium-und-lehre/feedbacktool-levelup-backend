<?php

namespace Studi\Domain;

use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;
use Common\Domain\User\Nachname;
use Common\Domain\User\Vorname;

final class StudiData implements DDDValueObject
{
    use DefaultValueObjectComparison;

    private Matrikelnummer $matrikelnummer;

    private Vorname $vorname;

    private Nachname $nachname;

    /** @var array<string, string> */
    private array $dataLine;

    /** @param array<string, string> $dataLine */
    public static function fromValues(
        Matrikelnummer $matrikelnummer,
        Vorname $vorname,
        Nachname $nachname,
        array $dataLine = []
    ): self {
        $object = new self();
        $object->matrikelnummer = $matrikelnummer;
        $object->vorname = $vorname;
        $object->nachname = $nachname;
        $object->dataLine = $dataLine;
        return $object;
    }

    /** @return Matrikelnummer */
    public function getMatrikelnummer(): Matrikelnummer {
        return $this->matrikelnummer;
    }

    /** @return Vorname */
    public function getVorname(): Vorname {
        return $this->vorname;
    }

    /** @return Nachname */
    public function getNachname(): Nachname {
        return $this->nachname;
    }

    /** @return array<string, string> */
    public function getDataLine(): array {
        return $this->dataLine;
    }
}