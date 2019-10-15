<?php

namespace StudiPruefung\Domain;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;
use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiHash;

interface StudiPruefungsRepository extends DDDRepository, FlushableRepository
{
    public function add(StudiPruefung $object): void;

    public function byId(StudiPruefungsId $id): ?StudiPruefung;

    /** @return StudiPruefung[] */
    public function all(): array;

    public function delete(StudiPruefung $object): void;

    public function nextIdentity(): StudiPruefungsId;

    /** @return StudiPruefung[] */
    public function allByStudiHash(StudiHash $studiHash): array;

    /** @return StudiPruefung[] */
    public function allByPruefungsId(PruefungsId $pruefungsId): array;

    public function byStudiHashUndPruefungsId(StudiHash $studiHash, PruefungsId $pruefungsId): ?StudiPruefung;
}
