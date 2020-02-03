<?php

namespace Pruefung\Domain;

use Common\Domain\DefaultEntityComparison;

class PruefungsItem
{
    use DefaultEntityComparison;

    private PruefungsItemId $id;

    private PruefungsId $pruefungsId;

    private ?ItemSchwierigkeit $itemSchwierigkeit;

    public static function create(
        PruefungsItemId $id,
        PruefungsId $pruefungsId,
        ?ItemSchwierigkeit $itemSchwierigkeit = NULL
    ): self {

        $object = new self();
        $object->id = $id;
        $object->pruefungsId = $pruefungsId;
        $object->itemSchwierigkeit = $itemSchwierigkeit;

        return $object;
    }

    public function getId(): PruefungsItemId {
        return $this->id;
    }

    public function getPruefungsId(): PruefungsId {
        return $this->pruefungsId;
    }

    public function getItemSchwierigkeit(): ?ItemSchwierigkeit {
        return $this->itemSchwierigkeit;
    }

    public function setItemSchwierigkeit(ItemSchwierigkeit $itemSchwierigkeit): void {
        $this->itemSchwierigkeit = $itemSchwierigkeit;
    }
}