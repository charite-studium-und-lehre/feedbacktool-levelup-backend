<?php

namespace Studi\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Studi\Domain\LoginHash;
use Studi\Domain\Studi;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiRepository;

/**
 * @method byId($objectId)
 */
final class DBStudiRepository implements StudiRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(Studi $object): void {
        $this->abstractDelete($object);
    }

    public function add(Studi $object): void {
        $this->abstractAdd($object);
    }

    public function byStudiHash(StudiHash $studiHash): ?Studi {
        return $this->abstractById($studiHash->getValue());
    }

    public function byLoginHash(LoginHash $loginHash): ?Studi {
        return $this->doctrineRepo->findOneBy(
            ["loginHash" => $loginHash]
        );
    }
}