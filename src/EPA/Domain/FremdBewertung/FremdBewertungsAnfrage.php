<?php

namespace EPA\Domain\FremdBewertung;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;
use Studi\Domain\LoginHash;

class FremdBewertungsAnfrage implements DDDEntity
{
    use DefaultEntityComparison;

    private FremdBewertungsAnfrageId $id;

    private LoginHash $loginHash;

    private FremdBewertungsAnfrageDaten $anfrageDaten;

    private FremdBewertungsAnfrageToken $anfrageToken;

    public static function create(
        FremdBewertungsAnfrageId $id,
        LoginHash $loginHash,
        FremdBewertungsAnfrageDaten $fremdBewertungsAnfrageDaten
    ): self {
        $object = new self();
        $object->id = $id;
        $object->loginHash = $loginHash;
        $object->anfrageDaten = $fremdBewertungsAnfrageDaten;
        $object->anfrageToken = FremdBewertungsAnfrageToken::create();

        return $object;
    }

    public function getId(): FremdBewertungsAnfrageId {
        return $this->id;
    }

    public function getLoginHash(): LoginHash {
        return $this->loginHash;
    }

    public function getAnfrageDaten(): FremdBewertungsAnfrageDaten {
        return $this->anfrageDaten;
    }

    public function getAnfrageToken(): FremdBewertungsAnfrageToken {
        return $this->anfrageToken;
    }

}