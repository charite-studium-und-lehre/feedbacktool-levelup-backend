<?php

namespace Pruefung\Domain\FrageAntwort;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;

interface FragenRepository extends DDDRepository, FlushableRepository
{
    public function add(Frage $object): void;

    public function byId(FragenId $id): ?Frage;

//    public function byFragenNummerUndPruefungsItemId(FragenId $id): ?Frage;

    /** @return Frage[] */
    public function all(): array;

    public function delete(Frage $object): void;

    public function nextIdentity(): FragenId;
}
