<?php

namespace Pruefung\Domain\FrageAntwort;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;

interface AntwortRepository extends DDDRepository, FlushableRepository
{
    public function add(Antwort $object): void;

    public function byId(AntwortId $id): ?Antwort;

    /** @return Antwort[] */
    public function all(): array;

    /** @return Antwort[] */
    public function allByFragenId(FragenId $fragenId): array;

    public function delete(Antwort $object): void;

    public function nextIdentity(): AntwortId;
}
