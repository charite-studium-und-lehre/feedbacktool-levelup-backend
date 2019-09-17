<?php

namespace Wertung\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use StudiPruefung\Domain\StudiPruefungsId;
use Wertung\Domain\StudiPruefungsWertung;
use Wertung\Domain\StudiPruefungsWertungRepository;

/**
 * @method StudiPruefungsWertung[] all()
 */
final class FileBasedSimpleStudiPruefungsWertungRepository extends AbstractCommonRepository implements StudiPruefungsWertungRepository
{
    use FileBasedRepoTrait;

    public function byId(StudiPruefungsId $id): ?StudiPruefungsWertung {
        return $this->abstractById($id);
    }

    public function byStudiPruefungsId(StudiPruefungsId $studiPruefungsId): ?StudiPruefungsWertung {
        foreach ($this->all() as $wertung) {
            if ($wertung->getStudiPruefungsId()->equals($studiPruefungsId)) {
                return $wertung;
            }
        }

        return NULL;
    }
}
