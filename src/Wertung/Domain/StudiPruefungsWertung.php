<?php

namespace Wertung\Domain;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;
use StudiPruefung\Domain\StudiPruefungsId;
use Wertung\Domain\Wertung\Wertung;

class StudiPruefungsWertung implements DDDEntity
{
    use DefaultEntityComparison;

    private StudiPruefungsId $studiPruefungsId;

    private Wertung $gesamtErgebnis;

    private ?Wertung $bestehensGrenze;

    private ?Wertung $kohortenWertung;

    public static function create(
        StudiPruefungsId $studiPruefungsId,
        Wertung $gesamtErgebnis,
        ?Wertung $bestehensGrenze = NULL,
        ?Wertung $kohortenWertung = NULL
    ): self {
        $object = new self();
        $object->studiPruefungsId = $studiPruefungsId;
        $object->gesamtErgebnis = $gesamtErgebnis;
        $object->bestehensGrenze = $bestehensGrenze;
        $object->kohortenWertung = $kohortenWertung;

        return $object;
    }

    public function getStudiPruefungsId(): StudiPruefungsId {
        return $this->studiPruefungsId;
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

    public function setBestehensGrenze(Wertung $bestehensGrenze): void {
        $this->bestehensGrenze = $bestehensGrenze;
    }

    public function getKohortenWertung(): ?Wertung {
        return $this->kohortenWertung;
    }

    public function setKohortenWertung(?Wertung $kohortenWertung = NULL): void {
        $this->kohortenWertung = $kohortenWertung;
    }

}