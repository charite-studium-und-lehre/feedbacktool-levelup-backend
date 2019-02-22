<?php

namespace Studi\Domain;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;

interface StudiRepository extends DDDRepository, FlushableRepository
{
    public function add(Studi $object): void;

    public function byHash(StudiHash $studiHash): ?Studi;

    /** @return Studi[] */
    public function all(): array;

    public function delete(Studi $object): void;
}
