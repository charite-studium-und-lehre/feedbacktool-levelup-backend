<?php

namespace EPA\Domain\FremdBewertung;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;
use EPA\Domain\EPABewertung;
use EPA\Domain\EPABewertungsDatum;
use Studi\Domain\LoginHash;

class FremdBewertung implements DDDEntity
{
    use DefaultEntityComparison;

    /** @var FremdBewertungsId */
    private $id;

    /** @var LoginHash */
    private $loginHash;

    /** @var EPABewertung[] */
    private $bewertungen;

    /** @var FremdBewertungsAnfrageDaten */
    private $anfrageDaten;

    /** @var EPABewertungsDatum */
    private $bewertungsDatum;

    public static function create(
        FremdBewertungsId $id,
        LoginHash $loginHash,
        FremdBewertungsAnfrageDaten $anfrageDaten,
        array $bewertungen
    ): self {
        $object = new self();
        $object->id = $id;
        $object->loginHash = $loginHash;
        $object->anfrageDaten = $anfrageDaten;
        $object->bewertungen = $bewertungen;
        $object->bewertungsDatum = EPABewertungsDatum::heute();

        return $object;
    }

    public function getId(): FremdBewertungsId {
        return FremdBewertungsId::fromInt($this->id);
    }

    public function getLoginHash(): LoginHash {
        return $this->loginHash;
    }

    public function getBewertungsDatum(): EPABewertungsDatum {
        return $this->bewertungsDatum;
    }

    /** @return EPABewertung[] */
    public function getBewertungen(): array {
        return $this->bewertungen;
    }

    public function getAnfrageDaten(): FremdBewertungsAnfrageDaten {
        return $this->anfrageDaten;
    }
}