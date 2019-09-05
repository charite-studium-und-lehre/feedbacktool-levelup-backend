<?php

namespace StudiPruefung\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Studi\Domain\StudiHash;
use StudiMeilenstein\Domain\Meilenstein;
use StudiMeilenstein\Domain\StudiMeilenstein;
use StudiMeilenstein\Domain\StudiMeilensteinId;
use StudiMeilenstein\Domain\StudiMeilensteinRepository;

/** @method StudiMeilenstein[] all() */
final class FileBasedSimpleStudiMeilensteinRepository extends AbstractCommonRepository implements StudiMeilensteinRepository
{
    use FileBasedRepoTrait;

    public function byId(StudiMeilensteinId $id): ?StudiMeilenstein {
        return $this->abstractById($id);
    }

    public function nextIdentity(): StudiMeilensteinId {
        return StudiMeilensteinId::fromInt($this->abstractNextIdentity());
    }

    /** @return StudiMeilenstein[] */
    public function allByStudiId(StudiHash $studiHash): array {
        $all = [];
        foreach ($this->all() as $studiMeilenstein) {
            if ($studiMeilenstein->getStudiHash()->equals($studiHash)) {
                $all[] = $studiMeilenstein;
            }
        }

        return $all;
    }

    public function byStudiIdUndMeilenstein(StudiHash $studiHash, Meilenstein $meilenstein): ?StudiMeilenstein {
        foreach ($this->all() as $studiMeilenstein) {
            if ($studiMeilenstein->getStudiHash()->equals($studiHash)
                && $studiMeilenstein->getMeilenstein()->equals($meilenstein)) {
                return $studiMeilenstein;
            }
        }

        return NULL;
    }
}
