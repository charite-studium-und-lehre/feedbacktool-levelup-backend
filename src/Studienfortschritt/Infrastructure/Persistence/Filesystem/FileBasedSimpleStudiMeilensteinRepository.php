<?php

namespace Studienfortschritt\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Studi\Domain\StudiHash;
use Studienfortschritt\Domain\FortschrittsItem;
use Studienfortschritt\Domain\StudiMeilenstein;
use Studienfortschritt\Domain\StudiMeilensteinId;
use Studienfortschritt\Domain\StudiMeilensteinRepository;

/** @method StudiMeilenstein[] all() */
final class FileBasedSimpleStudiMeilensteinRepository extends AbstractCommonRepository implements StudiMeilensteinRepository
{
    use FileBasedRepoTrait;

    public function byId(StudiMeilensteinId $id): ?StudiMeilenstein {
        return $this->abstractById($id);
    }

    public function nextIdentity(): StudiMeilensteinId {
        return StudiMeilensteinId::fromInt($this->abstractNextIdentity()->getValue());
    }

    /** @return StudiMeilenstein[] */
    public function allByStudiHash(StudiHash $studiHash): array {
        $all = [];
        foreach ($this->all() as $studiMeilenstein) {
            if ($studiMeilenstein->getStudiHash()->equals($studiHash)) {
                $all[] = $studiMeilenstein;
            }
        }

        return $all;
    }

    public function byStudiIdUndMeilenstein(StudiHash $studiHash, FortschrittsItem $meilenstein): ?StudiMeilenstein {
        foreach ($this->all() as $studiMeilenstein) {
            if ($studiMeilenstein->getStudiHash()->equals($studiHash)
                && $studiMeilenstein->getFortschrittsItem()->equals($meilenstein)) {
                return $studiMeilenstein;
            }
        }

        return NULL;
    }
}
