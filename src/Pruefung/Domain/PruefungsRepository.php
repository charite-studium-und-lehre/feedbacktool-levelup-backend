<?php

namespace Pruefung\Domain;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;

interface PruefungsRepository extends DDDRepository, FlushableRepository
{
    public function add(Pruefung $object): void;

    public function byId(PruefungsId $id): ?Pruefung;

    /** @return Pruefung[] */
    public function all(): array;

    public function delete(Pruefung $object): void;

    public function nextIdentity(): PruefungsId;
}
