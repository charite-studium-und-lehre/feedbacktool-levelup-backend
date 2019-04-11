<?php

namespace Wertung\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Lehrberechtigung\Infrastructure\Persistence\Common\AbstractSimpleLehrberechtigungRepository;
use Pruefung\Domain\Pruefung;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsRepository;
use Wertung\Domain\ItemWertung;
use Wertung\Domain\ItemWertungsId;
use Wertung\Domain\ItemWertungsRepository;

final class FileBasedSimpleItemWertungsRepository extends AbstractCommonRepository implements ItemWertungsRepository
{
    use FileBasedRepoTrait;

    public function byId(ItemWertungsId $id): ?ItemWertung {
        return $this->abstractById($id);
    }

    public function nextIdentity(): ItemWertungsId {
        return ItemWertungsId::fromInt($this->abstractNextIdentity());
    }
}
