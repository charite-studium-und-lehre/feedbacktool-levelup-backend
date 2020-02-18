<?php

namespace Pruefung\Domain;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;

interface PruefungsItemRepository extends DDDRepository, FlushableRepository
{
    public function add(PruefungsItem $object): void;

    public function byId(PruefungsItemId $id): ?PruefungsItem;

    /** @return PruefungsItem[] */
    public function all(): array;

    public function delete(PruefungsItem $object): void;

    /** @return PruefungsItem[] */
    public function allByPruefungsId(PruefungsId $id): array;

    public function nextIdentity(): PruefungsItemId;
}
