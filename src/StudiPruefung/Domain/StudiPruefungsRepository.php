<?php

namespace StudiPruefung\Domain;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;

interface StudiPruefungsRepository extends DDDRepository, FlushableRepository
{
    public function add(StudiPruefung $object): void;

    public function byId(StudiPruefungsId $id): ?StudiPruefung;

    /** @return StudiPruefung[] */
    public function all(): array;

    public function delete(StudiPruefung $object): void;

    public function nextIdentity(): StudiPruefungsId;
}
