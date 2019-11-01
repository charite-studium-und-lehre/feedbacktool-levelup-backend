<?php

namespace EPA\Domain\FremdBewertung;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;
use Studi\Domain\LoginHash;

class FremdBewertungsAnfrage implements DDDEntity
{
    use DefaultEntityComparison;

    /** @var FremdBewertungsAnfrageId */
    private $id;

    /** @var LoginHash */
    private $loginHash;

    /** @var FremdBewertungsAnfrageDaten */
    private $fremdBewertungsAnfrageDaten;

    /** @var FremdBewertungsAnfrageToken */
    private $fremdBewertungsAnfrageToken;

    public static function create(
        FremdBewertungsAnfrageId $id,
        LoginHash $loginHash,
        FremdBewertungsAnfrageDaten $fremdBewertungsAnfrageDaten
    ): self {
        $object = new self();
        $object->id = $id;
        $object->loginHash = $loginHash;
        $object->fremdBewertungsAnfrageDaten = $fremdBewertungsAnfrageDaten;
        $object->fremdBewertungsAnfrageToken = FremdBewertungsAnfrageToken::create();

        return $object;
    }

    public function getId(): FremdBewertungsAnfrageId {
        return FremdBewertungsAnfrageId::fromInt($this->id);
    }

    public function getLoginHash(): LoginHash {
        return $this->loginHash;
    }

    public function getFremdBewertungsAnfrageDaten(): FremdBewertungsAnfrageDaten {
        return $this->fremdBewertungsAnfrageDaten;
    }

    public function getFremdBewertungsAnfrageToken(): FremdBewertungsAnfrageToken {
        return $this->fremdBewertungsAnfrageToken;
    }

}