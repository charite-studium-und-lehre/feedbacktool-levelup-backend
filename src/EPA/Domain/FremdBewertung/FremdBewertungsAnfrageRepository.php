<?php

namespace EPA\Domain\FremdBewertung;

use Common\Domain\DDDRepository;
use Studi\Domain\LoginHash;

interface FremdBewertungsAnfrageRepository extends DDDRepository, FlushableRepository
{
    public
    function add(
        FremdBewertungsAnfrage $object
    ): void;

    public function byId(FremdBewertungsAnfrageId $id): ?FremdBewertungsAnfrage;

    /** @return FremdBewertungsAnfrage[] */
    public function all(): array;

    public function delete(FremdBewertungsAnfrage $object): void;

    public function nextIdentity(): FremdBewertungsAnfrageId;

    /** @return FremdBewertungsAnfrage[] */
    public function allByStudi(LoginHash $loginHash): array;

}