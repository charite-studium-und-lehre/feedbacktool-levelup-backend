<?php

namespace EPA\Domain\FremdBewertung;

use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;
use Common\Domain\User\Email;
use EPA\Domain\EPABewertungsDatum;

class FremdBewertungsAnfrageDaten implements DDDValueObject
{
    use DefaultValueObjectComparison;

    private FremdBewerterName $fremdBerwerterName;

    private Email $fremdBerwerterEmail;

    private EPABewertungsDatum $datum;

    private AnfragerName $studiName;

    private ?Email $studiEmail;

    private ?FremdBewertungsAnfrageTaetigkeiten $anfrageTaetigkeiten;

    private ?FremdBewertungsAnfrageKommentar $anfrageKommentar;

    public static function fromDaten(
        FremdBewerterName $fremdBewerterName,
        Email $fremdBewerterEmail,
        AnfragerName $studiName,
        Email $studiEmail,
        ?FremdBewertungsAnfrageTaetigkeiten $fremdBewertungsAnfrageTaetigkeiten,
        ?FremdBewertungsAnfrageKommentar $fremdBewertungsAnfrageKommentar
    ): self {

        $object = new self();
        $object->fremdBerwerterName = $fremdBewerterName;
        $object->fremdBerwerterEmail = $fremdBewerterEmail;
        $object->studiName = $studiName;
        $object->studiEmail = $studiEmail;
        $object->anfrageTaetigkeiten = $fremdBewertungsAnfrageTaetigkeiten;
        $object->anfrageKommentar = $fremdBewertungsAnfrageKommentar;
        $object->datum = EPABewertungsDatum::heute();

        return $object;
    }

    public function getFremdBerwerterName(): FremdBewerterName {
        return $this->fremdBerwerterName;
    }

    public function getFremdBerwerterEmail(): Email {
        return $this->fremdBerwerterEmail;
    }

    public function getDatum(): EPABewertungsDatum {
        return $this->datum;
    }

    public function getAnfrageTaetigkeiten(): ?FremdBewertungsAnfrageTaetigkeiten {
        return $this->anfrageTaetigkeiten;
    }

    public function getAnfrageKommentar(): ?FremdBewertungsAnfrageKommentar {
        return $this->anfrageKommentar;
    }

    public function getStudiName(): AnfragerName {
        return $this->studiName;
    }

    public function getStudiEmail(): ?Email {
        return $this->studiEmail;
    }

    public function getAnfrageDatenOhneStudiInfo(): self {
        $newObject = clone($this);
        $newObject->studiName = AnfragerName::fromString("-----");
        $newObject->studiEmail = Email::fromString("nobody@charite.de");
        $newObject->anfrageKommentar = NULL;
        $newObject->anfrageTaetigkeiten = NULL;

        return $newObject;
    }

}