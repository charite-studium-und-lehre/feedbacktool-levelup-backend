<?php

namespace Wertung\Domain\Wertung;

use Common\Domain\DefaultEntityComparison;
use Pruefung\Domain\PruefungsId;
use Wertung\Domain\WertungsItemId;

class WertungsItem
{
    use DefaultEntityComparison;

    /** @var WertungsItemId */
    private $id;

    /** @var PruefungsId */
    private $pruefungsId;

    public static function create(WertungsItemId $id, PruefungsId $pruefungsId): self {

        $object = new self();
        $object->id = $id;
        $object->pruefungsId = $pruefungsId;

        return $object;
    }

    public function getId(): WertungsItemId{
        return $this->id;
    }

    public function getPruefungsId(): PruefungsId{
        return $this->pruefungsId;
    }
}