<?php

namespace Wertung\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use StudiPruefung\Domain\StudiPruefungsId;
use Wertung\Domain\StudiPruefungsWertung;
use Wertung\Domain\StudiPruefungsWertungId;
use Wertung\Domain\StudiPruefungsWertungRepository;

final class DBStudiPruefungsWertungRepository implements StudiPruefungsWertungRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(StudiPruefungsWertung $object): void {
        $this->abstractDelete($object);
    }

    public function add(StudiPruefungsWertung $itemWertung): void {
        $this->abstractAdd($itemWertung);
    }

    public function byId(StudiPruefungsId $id): ?StudiPruefungsWertung {
        return $this->abstractById($id->getValue());
    }

    public function byStudiPruefungsId(StudiPruefungsId $studiPruefungsId): ?StudiPruefungsWertung {
        return $this->doctrineRepo->findOneBy(
            ["studiPruefungsId" => $studiPruefungsId,]
        );
    }
}