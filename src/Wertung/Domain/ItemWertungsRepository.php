<?php

namespace Wertung\Domain;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;
use Pruefung\Domain\PruefungsItemId;
use StudiPruefung\Domain\StudiPruefungsId;

interface ItemWertungsRepository extends DDDRepository, FlushableRepository
{
    public function add(ItemWertung $object): void;

    /** @return ItemWertung[] */
    public function all(): array;

    public function delete(ItemWertung $object): void;

    public function byId(ItemWertungsId $id): ?ItemWertung;

    public function nextIdentity(): ItemWertungsId;

    public function byStudiPruefungsIdUndPruefungssItemId(
        StudiPruefungsId $studiPruefungsId,
        PruefungsItemId $pruefungsItemId
    ): ?ItemWertung;
}