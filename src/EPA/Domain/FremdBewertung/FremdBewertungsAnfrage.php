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
    private $anfrageDaten;

    /** @var FremdBewertungsAnfrageToken */
    private $anfrageToken;

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
        return FremdBewertungsAnfrageId::fromInt($this->id);
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