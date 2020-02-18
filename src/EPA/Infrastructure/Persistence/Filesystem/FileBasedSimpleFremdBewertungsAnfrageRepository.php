<?php

namespace EPA\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrage;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageToken;
use Studi\Domain\LoginHash;

/** @method FremdBewertungsAnfrage[] all() */
final class FileBasedSimpleFremdBewertungsAnfrageRepository extends AbstractCommonRepository implements FremdBewertungsAnfrageRepository
{
    use FileBasedRepoTrait;

    public function byId(FremdBewertungsAnfrageId $id): ?FremdBewertungsAnfrage {
        return $this->abstractById($id);
    }

    public function nextIdentity(): FremdBewertungsAnfrageId {
        return FremdBewertungsAnfrageId::fromInt($this->abstractNextIdentity()->getValue());
    }

    /** @return FremdBewertungsAnfrage[] */
    public function allByStudi(LoginHash $loginHash): array {
        $returnArray = [];
        foreach ($this->all() as $anfrage) {
            if ($anfrage->getLoginHash() == $loginHash) {
                $returnArray[] = $anfrage;
            }
        }

        return $returnArray;
    }

    public function byToken(FremdBewertungsAnfrageToken $token): ?FremdBewertungsAnfrage {
        foreach ($this->all() as $anfrage) {
            if ($anfrage->getAnfrageToken()->equals($token)) {
                return $anfrage;
            }
        }

        return NULL;
    }
}
