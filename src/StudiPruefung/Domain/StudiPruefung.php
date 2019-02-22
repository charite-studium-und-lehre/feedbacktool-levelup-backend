<?php

namespace StudiPruefung\Domain;

use Common\Domain\DefaultEntityComparison;
use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiHash;
use Wertung\Domain\Wertung\WertungsInterface;

class StudiPruefung
{
    /** StudiPruefungsId */
    private $id;

    /** @var StudiHash */
    private $StudiHash;

    /** @var PruefungsId */
    private $pruefungsId;

    use DefaultEntityComparison;

    public static function fromValues(StudiPruefungsId $id, StudiHash $studiId, PruefungsId $pruefungsId) {
        $object = new self();
        $object->id = $id;
        $object->StudiHash = $studiId;
        $object->pruefungsId = $pruefungsId;

        return $object;
    }

    public function getId(): StudiPruefungsId {
        return $this->id;
    }

    public function getStudiHash(): StudiHash {
        return $this->StudiHash;
    }

    public function getPruefungsId(): PruefungsId {
        return $this->pruefungsId;
    }

}