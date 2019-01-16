<?php

namespace Pruefung\Domain;

use Common\Domain\DefaultEntityComparison;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItemId;

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

    public function getId(): PruefungsItemId{
        return $this->id;
    }

    public function getPruefungsId(): PruefungsId{
        return $this->pruefungsId;
    }
}