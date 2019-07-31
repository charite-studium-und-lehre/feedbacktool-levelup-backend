<?php

namespace Pruefung\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Pruefung\Domain\Pruefung;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsRepository;

final class DBPruefungsRepository implements PruefungsRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(Pruefung $object): void {
        $this->abstractDelete($object);
    }

    public function add(Pruefung $pruefung): void {
        $this->abstractAdd($pruefung);
    }

    public function byId(PruefungsId $pruefungsId): ?Pruefung {
        return $this->abstractById($pruefungsId->getValue());
    }

    public function nextIdentity(): PruefungsId {
        return PruefungsId::fromString($this->abstractNextIdentityAsInt());
    }

}