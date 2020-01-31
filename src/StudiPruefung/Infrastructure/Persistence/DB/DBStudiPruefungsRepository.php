<?php

namespace StudiPruefung\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiHash;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsId;
use StudiPruefung\Domain\StudiPruefungsRepository;

final class DBStudiPruefungsRepository implements StudiPruefungsRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(StudiPruefung $object): void {
        $this->abstractDelete($object);
    }

    public function add(StudiPruefung $pruefung): void {
        $this->abstractAdd($pruefung);
    }

    public function byId(StudiPruefungsId $id): ?StudiPruefung {
        return $this->abstractById($id);
    }

    public function nextIdentity(): StudiPruefungsId {
        return StudiPruefungsId::fromInt($this->abstractNextIdentityAsInt());
    }

    public function byStudiHashUndPruefungsId(StudiHash $studiHash, PruefungsId $pruefungsId): ?StudiPruefung {
        return $this->doctrineRepo->findOneBy(
            [
                "studiHash"      => $studiHash,
                "pruefungsId" => $pruefungsId,
            ]
        );
    }

    /** @return StudiPruefung[] */
    public function allByStudiHash(StudiHash $studiHash): array {
        return $this->doctrineRepo->findBy(
            [
                "studiHash" => $studiHash,
            ],
            ["pruefungsId" => "DESC"]
        );
    }

    /** @return StudiPruefung[] */
    public function allByPruefungsId(PruefungsId $pruefungsId): array {
        return $this->doctrineRepo->findBy(
            [
                "pruefungsId" => $pruefungsId,
            ],
        );
    }
}