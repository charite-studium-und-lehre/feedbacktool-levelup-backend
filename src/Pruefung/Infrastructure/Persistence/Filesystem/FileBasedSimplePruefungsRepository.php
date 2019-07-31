<?php

namespace Pruefung\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Lehrberechtigung\Infrastructure\Persistence\Common\AbstractSimpleLehrberechtigungRepository;
use Pruefung\Domain\Pruefung;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsRepository;

final class FileBasedSimplePruefungsRepository extends AbstractCommonRepository implements PruefungsRepository
{
    use FileBasedRepoTrait;

    public function byId(PruefungsId $id): ?Pruefung {
        return $this->abstractById($id);
    }

    public function nextIdentity(): PruefungsId {
        return PruefungsId::fromString($this->abstractNextIdentity());
    }
}
