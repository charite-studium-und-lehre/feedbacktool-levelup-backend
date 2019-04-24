<?php

namespace StudiPruefung\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Lehrberechtigung\Infrastructure\Persistence\Common\AbstractSimpleLehrberechtigungRepository;
use Pruefung\Domain\PruefungsId;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsId;
use StudiPruefung\Domain\StudiPruefungsRepository;

final class FileBasedSimpleStudiPruefungsRepository extends AbstractCommonRepository implements StudiPruefungsRepository
{
    use FileBasedRepoTrait;

    public function byId(StudiPruefungsId $id): ?StudiPruefung {
        return $this->abstractById($id);
    }

    public function nextIdentity(): StudiPruefungsId {
        return PruefungsId::fromInt($this->abstractNextIdentity());
    }
}
