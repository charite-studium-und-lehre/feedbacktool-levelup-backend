<?php

namespace EPA\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use EPA\Domain\EPA;
use EPA\Domain\SelbstBewertung;
use EPA\Domain\SelbstBewertungsId;
use EPA\Domain\SelbstBewertungsRepository;
use EPA\Domain\SelbstBewertungsTyp;
use Studi\Domain\LoginHash;

final class DBSelbstBewertungsRepository implements SelbstBewertungsRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(SelbstBewertung $object): void {
        $this->abstractDelete($object);
    }

    public function add(SelbstBewertung $pruefung): void {
        $this->abstractAdd($pruefung);
    }

    public function byId(SelbstBewertungsId $id): ?SelbstBewertung {
        return $this->abstractById($id->getValue());
    }

    public function nextIdentity(): SelbstBewertungsId {
        return SelbstBewertungsId::fromInt($this->abstractNextIdentityAsInt());
    }

    /** SelbstBewertung[] */
    public function allLatestByStudiUndTyp(LoginHash $loginHash, SelbstBewertungsTyp $typ): array {
        return $this->doctrineRepo->createQueryBuilder("selbstbewertung")
            ->andWhere("selbstbewertung.loginHash= :loginHash")
            ->setParameter("loginHash", $loginHash)
            ->andWhere("selbstbewertung.selbstBewertungsTyp.value = :typ")
            ->setParameter("typ", $typ->getValue())
            ->groupBy("selbstbewertung.selbstBewertungsTyp.value")
            ->addOrderBy("selbstbewertung.epaBewertungsDatum.value", "DESC")
            ->getQuery()->execute();
    }

    /** @return SelbstBewertung[] */
    public function allByStudi(LoginHash $loginHash): array {
        return $this->doctrineRepo->findBy(
            [
                "loginHash" => $loginHash,
            ]
        );
    }

    /** @return SelbstBewertung[] */
    public function latestByStudiUndTypUndEpa(
        LoginHash $loginHash,
        SelbstBewertungsTyp $typ,
        EPA $epa
    ): ?SelbstBewertung {
        foreach ($this->allLatestByStudiUndTyp($loginHash, $typ) as $bewertung) {
            /** @var $bewertung SelbstBewertung */
            if ($bewertung->getEpaBewertung()->getEpa()->equals($epa)) {
                return $bewertung;
            }
        }
        return NULL;
    }
}