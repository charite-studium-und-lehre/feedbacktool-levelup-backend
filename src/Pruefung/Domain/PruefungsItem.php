<?php

namespace Pruefung\Domain;

use Common\Domain\DefaultEntityComparison;

class PruefungsItem
{
    use DefaultEntityComparison;

    /** @var PruefungsItemId */
    private $id;

    /** @var PruefungsId */
    private $pruefungsId;

    public static function create(PruefungsItemId $id, PruefungsId $pruefungsId): self {

        $object = new self();
        $object->id = $id;
        $object->pruefungsId = $pruefungsId;

        return $object;
    }

    public function getId(): PruefungsItemId {
        return PruefungsItemId::fromString($this->id);
    }

    public function getPruefungsId(): PruefungsId {
        return PruefungsId::fromString($this->pruefungsId);
    }
}