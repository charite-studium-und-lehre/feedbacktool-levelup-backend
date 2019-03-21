<?php

namespace Pruefung\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Pruefung\Domain\Pruefung;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsRepository;

final class DBPruefungsRepository implements PruefungsRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(Pruefung $pruefung): void {
        $this->abstractDelete($pruefung);
    }

    public function add(Pruefung $pruefung): void {
        $this->abstractAdd($pruefung);
    }

    public function byId(PruefungsId $pruefungsId): ?Pruefung {
        return $this->abstractById($pruefungsId->getValue());
    }

    public function nextIdentity(): PruefungsId {
        return PruefungsId::fromInt($this->abstractNextIdentityAsInt());
    }

}