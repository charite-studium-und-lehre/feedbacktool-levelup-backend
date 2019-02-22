<?php

namespace Studi\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Studi\Domain\Studi;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiRepository;

/**
 * @method  byId($objectId)
 */
final class DBStudiRepository implements StudiRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(Studi $pruefung): void {
        $this->abstractDelete($pruefung);
    }

    public function add(Studi $pruefung): void {
        $this->abstractAdd($pruefung);
    }

    public function byHash(StudiHash $studiHash): ?Studi {
        return $this->abstractById($studiHash->getValue());
    }
}