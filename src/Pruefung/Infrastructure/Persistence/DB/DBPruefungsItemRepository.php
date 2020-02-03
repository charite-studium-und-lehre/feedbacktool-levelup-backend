<?php

namespace Pruefung\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemId;
use Pruefung\Domain\PruefungsItemRepository;

final class DBPruefungsItemRepository implements PruefungsItemRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(PruefungsItem $pruefungsItem): void {
        $this->abstractDelete($pruefungsItem);
    }

    public function add(PruefungsItem $pruefungsItem): void {
        $this->abstractAdd($pruefungsItem);
    }

    public function byId(PruefungsItemId $studiHash): ?PruefungsItem {
        return $this->abstractById($studiHash);
    }


    public function nextIdentity(): PruefungsItemId {
        return PruefungsItemId::fromString($this->abstractNextIdentityAsInt());
    }

    public function allByPruefungsId(PruefungsId $id): array {
        return $this->doctrineRepo->findBy(
            ["pruefungsId" => $id]
        );
    }
}