<?php

namespace Wertung\Domain;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;
use StudiPruefung\Domain\StudiPruefungsId;
use Wertung\Domain\Wertung\Wertung;

class StudiPruefungsWertung implements DDDEntity
{
    use DefaultEntityComparison;

    /** @var StudiPruefungsId */
    private $studiPruefungsId;

    /** @var Wertung */
    private $gesamtErgebnis;

    /** @var ?Wertung */
    private $bestehensGrenze;

    public static function create(
        StudiPruefungsId $studiPruefungsId,
        Wertung $gesamtErgebnis,
        ?Wertung $bestehensGrenze
    ): self {
        $object = new self();
        $object->studiPruefungsId = $studiPruefungsId;
        $object->gesamtErgebnis = $gesamtErgebnis;
        $object->bestehensGrenze = $bestehensGrenze;

        return $object;
    }

    public function getStudiPruefungsId(): StudiPruefungsId {
        return StudiPruefungsId::fromInt($this->studiPruefungsId);
    }

    public function getGesamtErgebnis(): Wertung {
        return $this->gesamtErgebnis;
    }

    public function setGesamtErgebnis(Wertung $gesamtErgebnis): void {
        $this->gesamtErgebnis = $gesamtErgebnis;
    }

    public function getBestehensGrenze(): ?Wertung {
        return $this->bestehensGrenze;
    }

    public function setBestehensGrenze($bestehensGrenze): void {
        $this->bestehensGrenze = $bestehensGrenze;
    }
}