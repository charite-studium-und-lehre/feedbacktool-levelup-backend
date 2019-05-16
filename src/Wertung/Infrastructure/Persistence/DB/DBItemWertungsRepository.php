<?php

namespace Wertung\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Pruefung\Domain\PruefungsItemId;
use StudiPruefung\Domain\StudiPruefungsId;
use Wertung\Domain\ItemWertung;
use Wertung\Domain\ItemWertungsId;
use Wertung\Domain\ItemWertungsRepository;

final class DBItemWertungsRepository implements ItemWertungsRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(ItemWertung $object): void {
        $this->abstractDelete($object);
    }

    public function add(ItemWertung $itemWertung): void {
        $this->abstractAdd($itemWertung);
    }

    public function byId(ItemWertungsId $itemWertungsId): ?ItemWertung {
        return $this->abstractById($itemWertungsId->getValue());
    }

    public function nextIdentity(): ItemWertungsId {
        return ItemWertungsId::fromInt($this->abstractNextIdentityAsInt());
    }

    public function byStudiPruefungsIdUndPruefungssItemId(
        StudiPruefungsId $studiPruefungsId,
        PruefungsItemId $pruefungsItemId
    ): ?ItemWertung {
        return $this->doctrineRepo->findOneBy(
            [
                "studiPruefungsId" => $studiPruefungsId->getValue(),
                "pruefungsItemId"  => $pruefungsItemId->getValue(),
            ]
        );
    }

}