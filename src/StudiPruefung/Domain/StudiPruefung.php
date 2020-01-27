<?php

namespace StudiPruefung\Domain;

use Common\Domain\DefaultEntityComparison;
use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiHash;

class StudiPruefung
{
    private StudiPruefungsId $id;

    private StudiHash $studiHash;

    private PruefungsId $pruefungsId;

    private bool $bestanden;

    use DefaultEntityComparison;

    public static function fromValues(
        StudiPruefungsId $id,
        StudiHash $studiHash,
        PruefungsId $pruefungsId,
        bool $bestanden = TRUE
    ): self {
        $object = new self();
        $object->id = $id;
        $object->studiHash = $studiHash;
        $object->pruefungsId = $pruefungsId;
        $object->bestanden = $bestanden;

        return $object;
    }

    public function getId(): StudiPruefungsId {
        return StudiPruefungsId::fromInt($this->id->getValue());
    }

    public function getStudiHash(): StudiHash {
        return $this->studiHash;
    }

    public function getPruefungsId(): PruefungsId {
        return PruefungsId::fromString($this->pruefungsId->getValue());
    }

    public function isBestanden(): bool {
        return $this->bestanden;
    }

    public function setBestanden(bool $bestanden): void {
        $this->bestanden = $bestanden;
    }

}