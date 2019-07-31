<?php

namespace StudiPruefung\Domain;

use Common\Domain\DefaultEntityComparison;
use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiHash;

class StudiPruefung
{
    /** @var StudiPruefungsId */
    private $id;

    /** @var StudiHash */
    private $studiHash;

    /** @var PruefungsId */
    private $pruefungsId;

    use DefaultEntityComparison;

    public static function fromValues(StudiPruefungsId $id, StudiHash $studiHash, PruefungsId $pruefungsId) {
        $object = new self();
        $object->id = $id;
        $object->studiHash = $studiHash;
        $object->pruefungsId = $pruefungsId;

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

}