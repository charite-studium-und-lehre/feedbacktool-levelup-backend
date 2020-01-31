<?php

namespace StudiPruefung\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiHash;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsId;
use StudiPruefung\Domain\StudiPruefungsRepository;

/** @method StudiPruefung[] all() */
final class FileBasedSimpleStudiPruefungsRepository extends AbstractCommonRepository implements StudiPruefungsRepository
{
    use FileBasedRepoTrait;

    public function byId(StudiPruefungsId $id): ?StudiPruefung {
        return $this->abstractById($id);
    }

    public function nextIdentity(): StudiPruefungsId {
        return StudiPruefungsId::fromInt($this->abstractNextIdentity()->getValue());
    }

    public function byStudiHashUndPruefungsId(StudiHash $studiHash, PruefungsId $pruefungsId): ?StudiPruefung {
        foreach ($this->all() as $studiPruefung) {
            if ($studiPruefung->getStudiHash()->equals($studiHash)
                && $studiPruefung->getPruefungsId()->equals($pruefungsId)) {
                return $studiPruefung;
            }
        }

        return NULL;
    }

    /** @return StudiPruefung[] */
    public function allByStudiHash(StudiHash $studiHash): array {
        $resultArray = [];
        foreach ($this->all() as $studiPruefung) {
            if ($studiPruefung->getStudiHash()->equals($studiHash)) {
                $resultArray[] = $studiPruefung;
            }
        }

        return $resultArray;
    }

    /** @return StudiPruefung[] */
    public function allByPruefungsId(PruefungsId $pruefungsId): array {
        $resultArray = [];
        foreach ($this->all() as $studiPruefung) {
            if ($studiPruefung->getPruefungsId()->equals($pruefungsId)) {
                $resultArray[] = $studiPruefung;
            }
        }

        return $resultArray;
    }
}
