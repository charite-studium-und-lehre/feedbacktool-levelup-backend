<?php

namespace Wertung\Domain;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;
use StudiPruefung\Domain\StudiPruefungsId;

interface StudiPruefungsWertungRepository extends DDDRepository, FlushableRepository
{
    public function add(StudiPruefungsWertung $object): void;

    /** @return StudiPruefungsWertung[] */
    public function all(): array;

    public function delete(StudiPruefungsWertung $object): void;

    public function byId(StudiPruefungsId $id): ?StudiPruefungsWertung;

    public function byStudiPruefungsId(StudiPruefungsId $studiPruefungsId): ?StudiPruefungsWertung;
}