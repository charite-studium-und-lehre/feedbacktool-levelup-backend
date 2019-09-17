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

    /** @var ?ItemSchwierigkeit */
    private $itemSchwierigkeit;

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
        return PruefungsItemId::fromString($this->id);
    }

    public function getPruefungsId(): PruefungsId {
        return PruefungsId::fromString($this->pruefungsId);
    }

   public function getItemSchwierigkeit(): ?ItemSchwierigkeit {
        return $this->itemSchwierigkeit;
    }

    public function setItemSchwierigkeit(ItemSchwierigkeit $itemSchwierigkeit): void {
        $this->itemSchwierigkeit = $itemSchwierigkeit;
    }
}