<?php

namespace EPA\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrage;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageToken;
use Studi\Domain\LoginHash;

final class DBFremdBewertungsAnfrageRepository implements FremdBewertungsAnfrageRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(FremdBewertungsAnfrage $object): void {
        $this->abstractDelete($object);
    }

    public function add(FremdBewertungsAnfrage $object): void {
        $this->abstractAdd($object);
    }

    public function byId(FremdBewertungsAnfrageId $id): ?FremdBewertungsAnfrage {
        return $this->abstractById($id->getValue());
    }

    public function nextIdentity(): FremdBewertungsAnfrageId {
        return FremdBewertungsAnfrageId::fromInt($this->abstractNextIdentityAsInt());
    }

    /** @return FremdBewertungsAnfrage[] */
    public function allByStudi(LoginHash $loginHash): array {
        return $this->doctrineRepo->findBy(
            [
                "loginHash" => $loginHash,
            ]
        );
    }

    public function byToken(FremdBewertungsAnfrageToken $token): ?FremdBewertungsAnfrage {
        return $this->doctrineRepo->findOneBy(
            [
                "anfrageToken.value" => $token->getValue(),
            ]
        );
    }
}