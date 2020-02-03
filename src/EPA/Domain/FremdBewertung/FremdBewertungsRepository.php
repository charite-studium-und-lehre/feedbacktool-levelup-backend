<?php

namespace EPA\Domain\FremdBewertung;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;
use Studi\Domain\LoginHash;

interface FremdBewertungsRepository extends DDDRepository, FlushableRepository
{
    public function add(FremdBewertung $object): void;

    public function byId(FremdBewertungsId $id): ?FremdBewertung;

    /** @return FremdBewertung[] */
    public function all(): array;

    public function delete(FremdBewertung $object): void;

    public function nextIdentity(): FremdBewertungsId;

    /** @return FremdBewertung[] */
    public function allByStudi(LoginHash $loginHash): array;

}