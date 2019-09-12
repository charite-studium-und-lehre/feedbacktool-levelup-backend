<?php

namespace StudiMeilenstein\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Studi\Domain\StudiHash;
use StudiMeilenstein\Domain\Meilenstein;
use StudiMeilenstein\Domain\StudiMeilenstein;
use StudiMeilenstein\Domain\StudiMeilensteinId;
use StudiMeilenstein\Domain\StudiMeilensteinRepository;

final class DBStudiMeilensteinRepository implements StudiMeilensteinRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(StudiMeilenstein $object): void {
        $this->abstractDelete($object);
    }

    public function add(StudiMeilenstein $pruefung): void {
        $this->abstractAdd($pruefung);
    }

    public function byId(StudiMeilensteinId $id): ?StudiMeilenstein {
        return $this->abstractById($id->getValue());
    }

    public function nextIdentity(): StudiMeilensteinId {
        return StudiMeilensteinId::fromInt($this->abstractNextIdentityAsInt());
    }

    /** @return StudiMeilenstein[] */
    public function allByStudiHash(StudiHash $studiHash): array {
        return $this->doctrineRepo->findBy(
            [
                "studiHash" => $studiHash,
            ]
        );
    }

    public function byStudiIdUndMeilenstein(StudiHash $studiHash, Meilenstein $meilenstein): ?StudiMeilenstein {
        return $this->doctrineRepo->findOneBy(
            [
                "studiHash"   => $studiHash,
                "meilenstein" => $meilenstein,
            ]
        );
    }

}