<?php

namespace Studi\Domain;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;

interface StudiInternRepository extends DDDRepository, FlushableRepository
{
    public function add(StudiIntern $object): void;

    public function byMatrikelnummer(Matrikelnummer $matrikelnummer): ?StudiIntern;

    public function byStudiHash(StudiHash $studiHash): ?StudiIntern;

    /** @return StudiIntern[] */
    public function all(): array;

    public function delete(StudiIntern $object): void;
}
