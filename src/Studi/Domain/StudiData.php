<?php

namespace Studi\Domain;

use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;
use Common\Domain\User\Nachname;
use Common\Domain\User\Vorname;

final class StudiData implements DDDValueObject
{
    use DefaultValueObjectComparison;

    /** @var Matrikelnummer */
    private $matrikelnummer;

    /** @var Vorname */
    private $vorname;

    /** @var Nachname */
    private $nachname;

    /** @var Geburtsdatum */
    private $geburtsdatum;

    /** @var array */
    private $dataLine;

    public static function fromValues(
        Matrikelnummer $matrikelnummer,
        Vorname $vorname,
        Nachname $nachname,
        Geburtsdatum $geburtsdatum,
        array $dataLine
    ): self {
        $object = new self();
        $object->matrikelnummer = $matrikelnummer;
        $object->vorname = $vorname;
        $object->nachname = $nachname;
        $object->geburtsdatum = $geburtsdatum;
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

    /** @return Geburtsdatum */
    public function getGeburtsdatum(): Geburtsdatum {
        return $this->geburtsdatum;
    }

    public function getDataLine(): array {
        return $this->dataLine;
    }

}