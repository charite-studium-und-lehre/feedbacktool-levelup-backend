<?php

namespace EPA\Domain;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;
use Studi\Domain\StudiHash;

class SelbstBewertung implements DDDEntity
{
    use DefaultEntityComparison;

    /** @var SelbstBewertungsId */
    private $id;

    /** @var StudiHash */
    private $studiHash;

    /** @var EPABewertung */
    private $epaBewertung;

    /** @var SelbstBewertungsTyp */
    private $selbstBewertungsTyp;

    /** @var EPABewertungsDatum */
    private $epaBewertungsDatum;

    public static function create(
        SelbstBewertungsId $id,
        StudiHash $studiHash,
        EPABewertung $epaBewertung,
        SelbstBewertungsTyp $selbstBewertungsTyp
    ): self {
        $object = new self();
        $object->id = $id;
        $object->studiHash = $studiHash;
        $object->epaBewertung = $epaBewertung;
        $object->selbstBewertungsTyp = $selbstBewertungsTyp;
        $object->epaBewertungsDatum = EPABewertungsDatum::heute();

        return $object;
    }

    public function getId(): SelbstBewertungsId {
        return SelbstBewertungsId::fromInt($this->id);
    }

    public function getStudiHash(): StudiHash {
        return $this->studiHash;
    }

    public function getEpaBewertung(): EPABewertung {
        return $this->epaBewertung;
    }

    public function erhoeheBewertung(): void {
        $this->epaBewertung = $this->epaBewertung->erhoeheStufe();
        $this->epaBewertungsDatum = EPABewertungsDatum::heute();
    }

    public function vermindereBewertung(): void {
        $this->epaBewertung = $this->epaBewertung->vermindereStufe();
        $this->epaBewertungsDatum = EPABewertungsDatum::heute();
    }

    public function getSelbstBewertungsTyp(): SelbstBewertungsTyp {
        return $this->selbstBewertungsTyp;
    }

    public function getEpaBewertungsDatum(): EPABewertungsDatum {
        return $this->epaBewertungsDatum;
    }

}