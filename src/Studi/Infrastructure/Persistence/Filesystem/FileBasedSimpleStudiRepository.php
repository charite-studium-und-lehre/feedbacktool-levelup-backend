<?php

namespace Studi\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Studi\Domain\Studi;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiRepository;

/**
 * @method byId($objectId)
 */
final class FileBasedSimpleStudiRepository extends AbstractCommonRepository implements StudiRepository
{
    use FileBasedRepoTrait;

    public function byHash(StudiHash $hash): ?Studi {
        foreach ($this->all() as $entity) {
            /* @var $entity Studi */
            if ($entity->getStudiHash()->equals($hash)) {
                return $entity;
            }
        }
    }
}
