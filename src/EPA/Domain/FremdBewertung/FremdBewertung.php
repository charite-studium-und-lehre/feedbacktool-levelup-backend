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

    /** @var EPABewertungsDatum */
    private $epaBewertungsDatum;

    public static function create(
        FremdBewertungsId $id,
        LoginHash $loginHash,
        array $bewertungen
    ): self {
        $object = new self();
        $object->id = $id;
        $object->loginHash = $loginHash;
        $object->bewertungen = $bewertungen;
        $object->epaBewertungsDatum = EPABewertungsDatum::heute();

        return $object;
    }

    public function getId(): SelbstBewertungsId {
        return SelbstBewertungsId::fromInt($this->id);
    }

    public function getLoginHash(): LoginHash {
        return $this->loginHash;
    }

    public function getEpaBewertungsDatum(): EPABewertungsDatum {
        return $this->epaBewertungsDatum;
    }

    public function getBewertungen(): array {
        return $this->bewertungen;
    }



}