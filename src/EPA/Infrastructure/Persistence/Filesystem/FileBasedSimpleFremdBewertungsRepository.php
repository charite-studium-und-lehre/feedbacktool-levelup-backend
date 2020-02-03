<?php

namespace EPA\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use EPA\Domain\FremdBewertung\FremdBewertung;
use EPA\Domain\FremdBewertung\FremdBewertungsId;
use EPA\Domain\FremdBewertung\FremdBewertungsRepository;
use Studi\Domain\LoginHash;

/** @method FremdBewertung[] all() */
final class FileBasedSimpleFremdBewertungsRepository extends AbstractCommonRepository implements FremdBewertungsRepository
{
    use FileBasedRepoTrait;

    public function byId(FremdBewertungsId $id): ?FremdBewertung {
        return $this->abstractById($id);
    }

    public function nextIdentity(): FremdBewertungsId {
        return FremdBewertungsId::fromInt($this->abstractNextIdentity()->getValue());
    }

    /** @return FremdBewertung[] */
    public function allByStudi(LoginHash $loginHash): array {
        $returnArray = [];
        foreach ($this->all() as $anfrage) {
            if ($anfrage->getLoginHash() == $loginHash) {
                $returnArray[] = $anfrage;
            }
        }

        return $returnArray;
    }
}
