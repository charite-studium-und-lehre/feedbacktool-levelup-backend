<?php

namespace StudiMeilenstein\Domain;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;
use Studi\Domain\StudiHash;

interface StudiMeilensteinRepository extends DDDRepository, FlushableRepository
{
    public function add(StudiMeilenstein $object): void;

    public function byId(StudiMeilensteinId $id): ?StudiMeilenstein;

    /** @return StudiMeilenstein[] */
    public function all(): array;

    public function delete(StudiMeilenstein $object): void;

    /** @return StudiMeilenstein[] */
    public function allByStudiHash(StudiHash $studiHash): array;

    public function byStudiIdUndMeilenstein(StudiHash $studiHash, Meilenstein $meilenstein): ?StudiMeilenstein;

    public function nextIdentity(): StudiMeilensteinId;

}
