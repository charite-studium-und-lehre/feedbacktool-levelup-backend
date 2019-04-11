<?php

namespace StudiPruefung\Domain;

use Common\Domain\DefaultEntityComparison;
use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiHash;

class StudiPruefung
{
    /** StudiPruefungsId */
    private $id;

    /** @var StudiHash */
    private $StudiHash;

    /** @var PruefungsId */
    private $pruefungsId;

    use DefaultEntityComparison;

    public static function fromValues(PruefungsItemId $id, StudiHash $studiHash, PruefungsId $pruefungsId) {
        $object = new self();
        $object->id = $id;
        $object->StudiHash = $studiHash;
        $object->pruefungsId = $pruefungsId;

        return $object;
    }

    public function getId(): PruefungsItemId {
        return $this->id;
    }

    public function getStudiHash(): StudiHash {
        return $this->StudiHash;
    }

    public function getPruefungsId(): PruefungsId {
        return $this->pruefungsId;
    }

}