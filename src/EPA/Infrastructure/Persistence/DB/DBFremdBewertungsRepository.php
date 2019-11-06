<?php

namespace EPA\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use EPA\Domain\FremdBewertung\FremdBewertung;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrage;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use EPA\Domain\FremdBewertung\FremdBewertungsId;
use EPA\Domain\FremdBewertung\FremdBewertungsRepository;
use Studi\Domain\LoginHash;

final class DBFremdBewertungsRepository implements FremdBewertungsRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(FremdBewertung $object): void {
        $this->abstractDelete($object);
    }

    public function add(FremdBewertung $object): void {
        $this->abstractAdd($object);
    }

    public function byId(FremdBewertungsId $id): ?FremdBewertung {
        return $this->abstractById($id->getValue());
    }

    public function nextIdentity(): FremdBewertungsId {
        return FremdBewertungsId::fromInt($this->abstractNextIdentityAsInt());
    }

    /** @return FremdBewertung[] */
    public function allByStudi(LoginHash $loginHash): array {
        return $this->doctrineRepo->findBy(
            [
                "loginHash" => $loginHash,
            ]
        );
    }
}