<?php

namespace EPA\Domain\FremdBewertung;

use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;
use Common\Domain\User\Email;
use EPA\Domain\EPABewertungsDatum;

class FremdBewertungsAnfrageDaten implements DDDValueObject
{
    use DefaultValueObjectComparison;

    /** @var FremdBewerterName */
    private $fremdBerwerterName;

    /** @var Email */
    private $fremdBerwerterEmail;

    /** @var EPABewertungsDatum */
    private $datum;

    /** @var ?FremdBewertungsAnfrageTaetigkeiten */
    private $fremdBewertungsAnfrageTaetigkeiten;

    /** @var ?FremdBewertungsAnfrageKommentar */
    private $fremdBewertungsAnfrageKommentar;

    public static function fromDaten(
        FremdBewerterName $fremdBewerterName,
        Email $fremdBewerterEmail,
        ?FremdBewertungsAnfrageTaetigkeiten $fremdBewertungsAnfrageTaetigkeiten,
        ?FremdBewertungsAnfrageKommentar $fremdBewertungsAnfrageKommentar
    ): self {

        $object = new self();
        $object->fremdBerwerterName = $fremdBewerterName;
        $object->fremdBerwerterEmail = $fremdBewerterEmail;
        $object->fremdBewertungsAnfrageTaetigkeiten = $fremdBewertungsAnfrageTaetigkeiten;
        $object->fremdBewertungsAnfrageKommentar = $fremdBewertungsAnfrageKommentar;
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

    public function getFremdBewertungsAnfrageTaetigkeiten(): ?FremdBewertungsAnfrageTaetigkeiten {
        return $this->fremdBewertungsAnfrageTaetigkeiten;
    }

    public function getFremdBewertungsAnfrageKommentar(): ?FremdBewertungsAnfrageKommentar {
        return $this->fremdBewertungsAnfrageKommentar;
    }



}