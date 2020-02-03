<?php

namespace EPA\Domain\SelbstBewertung;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;
use EPA\Domain\EPABewertung;
use EPA\Domain\EPABewertungsDatum;
use Studi\Domain\LoginHash;

class SelbstBewertung implements DDDEntity
{
    use DefaultEntityComparison;

    private SelbstBewertungsId $id;

    private LoginHash $loginHash;

    private EPABewertung $epaBewertung;

    private SelbstBewertungsTyp $selbstBewertungsTyp;

    private EPABewertungsDatum $epaBewertungsDatum;

    public static function create(
        SelbstBewertungsId $id,
        LoginHash $loginHash,
        EPABewertung $epaBewertung,
        SelbstBewertungsTyp $selbstBewertungsTyp
    ): self {
        $object = new self();
        $object->id = $id;
        $object->loginHash = $loginHash;
        $object->epaBewertung = $epaBewertung;
        $object->selbstBewertungsTyp = $selbstBewertungsTyp;
        $object->epaBewertungsDatum = EPABewertungsDatum::heute();

        return $object;
    }

    public function getId(): SelbstBewertungsId {
        return $this->id;
    }

    public function getLoginHash(): LoginHash {
        return $this->loginHash;
    }

    public function getEpaBewertung(): EPABewertung {
        return $this->epaBewertung;
    }

    public function setzeBewertung(int $bewertung): void {
        $this->epaBewertung = $this->epaBewertung->setzeStufe($bewertung);
        $this->epaBewertungsDatum = EPABewertungsDatum::heute();
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