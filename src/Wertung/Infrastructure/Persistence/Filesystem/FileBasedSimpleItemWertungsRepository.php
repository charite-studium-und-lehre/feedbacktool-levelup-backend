<?php

namespace Wertung\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Pruefung\Domain\PruefungsItemId;
use StudiPruefung\Domain\StudiPruefungsId;
use Wertung\Domain\ItemWertung;
use Wertung\Domain\ItemWertungsId;
use Wertung\Domain\ItemWertungsRepository;

/**
 * @method ItemWertung[] all()
 */
final class FileBasedSimpleItemWertungsRepository extends AbstractCommonRepository implements ItemWertungsRepository
{
    use FileBasedRepoTrait;

    public function byId(ItemWertungsId $id): ?ItemWertung {
        return $this->abstractById($id);
    }

    public function nextIdentity(): ItemWertungsId {
        return ItemWertungsId::fromInt($this->abstractNextIdentity());
    }

    public function byStudiPruefungsIdUndPruefungssItemId(
        StudiPruefungsId $studiPruefungsId,
        PruefungsItemId $pruefungsItemId
    ): ?ItemWertung {
        foreach ($this->all() as $wertung) {
            if ($wertung->getStudiPruefungsId()->equals($studiPruefungsId)
                && $wertung->getPruefungsItemId()->equals($pruefungsItemId)
            ) {
                return $wertung;
            }
        }

        return NULL;
    }

    /** @return ItemWertung[] */
    public function allByPruefungssItemId(PruefungsItemId $pruefungsItemId): array {
        $resultArray = [];
        foreach ($this->all() as $wertung) {
            if ($wertung->getPruefungsItemId()->equals($pruefungsItemId)) {
                $resultArray[] = $wertung;
            }
        }
        return $resultArray;
    }
}
