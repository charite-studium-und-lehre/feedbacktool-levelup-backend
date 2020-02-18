<?php

namespace Pruefung\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemId;
use Pruefung\Domain\PruefungsItemRepository;

final class FileBasedSimplePruefungsItemRepository extends AbstractCommonRepository implements PruefungsItemRepository
{
    use FileBasedRepoTrait;

    public function byId(PruefungsItemId $id): ?PruefungsItem {
        return $this->abstractById($id);
    }

    public function nextIdentity(): PruefungsItemId {
        return PruefungsItemId::fromString($this->abstractNextIdentity());
    }

    /** @return PruefungsItem[] */
    public function allByPruefungsId(PruefungsId $id): array {
        $resultArray = [];
        foreach ($this->all() as $pruefungsItem) {
            if ($pruefungsItem->getPruefungsId()->equals($id)) {
                $resultArray[] = $pruefungsItem;
            }
        }

        return $resultArray;
    }
}
