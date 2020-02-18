<?php

namespace Studi\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Studi\Domain\LoginHash;
use Studi\Domain\Studi;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiRepository;

/**
 * @method byId($objectId)
 */
final class FileBasedSimpleStudiRepository extends AbstractCommonRepository implements StudiRepository
{
    use FileBasedRepoTrait;

    public function byStudiHash(StudiHash $hash): ?Studi {
        foreach ($this->all() as $entity) {
            /* @var $entity Studi */
            if ($entity->getStudiHash()->equals($hash)) {
                return $entity;
            }
        }
    }

    public function byLoginHash(LoginHash $loginHash): ?Studi {
        foreach ($this->all() as $entity) {
            /* @var $entity Studi */
            if ($entity->getLoginHash() && $entity->getLoginHash()->equals($loginHash)) {
                return $entity;
            }
        }

        return NULL;
    }
}
