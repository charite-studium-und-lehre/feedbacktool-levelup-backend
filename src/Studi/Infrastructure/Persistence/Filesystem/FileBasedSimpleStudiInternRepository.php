<?php

namespace Studi\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\StudiIntern;
use Studi\Domain\StudiInternRepository;

/**
 * @method byId($objectId)
 */
final class FileBasedSimpleStudiInternRepository extends AbstractCommonRepository implements StudiInternRepository
{
    use FileBasedRepoTrait;

    public function byMatrikelnummer(Matrikelnummer $matrikelnummer): ?StudiIntern {
        foreach ($this->all() as $entity) {
            /* @var $entity StudiIntern */
            if ($entity->getMatrikelnummer()->equals($matrikelnummer)) {
                return $entity;
            }
        }

        return NULL;
    }
}
