<?php

namespace Pruefung\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Pruefung\Domain\FrageAntwort\Frage;
use Pruefung\Domain\FrageAntwort\FragenId;
use Pruefung\Domain\FrageAntwort\FragenRepository;

final class FileBasedSimplePruefungsRepository extends AbstractCommonRepository implements FragenRepository
{
    use FileBasedRepoTrait;

    public function byId(FragenId $id): ?Frage {
        return $this->abstractById($id);
    }

    public function nextIdentity(): FragenId {
        return FragenId::fromString($this->abstractNextIdentity());
    }
}
