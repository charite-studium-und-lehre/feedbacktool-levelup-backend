<?php

namespace Pruefung\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Pruefung\Domain\FrageAntwort\Antwort;
use Pruefung\Domain\FrageAntwort\AntwortId;
use Pruefung\Domain\FrageAntwort\AntwortRepository;
use Pruefung\Domain\FrageAntwort\FragenId;

/** @method Antwort[] all()
 */
final class FileBasedSimpleAntwortRepository extends AbstractCommonRepository implements AntwortRepository
{
    use FileBasedRepoTrait;

    public function byId(AntwortId $id): ?Antwort {
        return $this->abstractById($id);
    }

    public function nextIdentity(): AntwortId {
        return AntwortId::fromString($this->abstractNextIdentity());
    }

    /** @return Antwort[] */
    public function allByFragenId(FragenId $fragenId): array {
        $returnArray = [];
        foreach ($this->all() as $antwort) {
            if ($antwort->getFragenId()->equals($fragenId)) {
                $returnArray[] = $antwort;
            }
        }
        return $returnArray;
    }
}
