<?php

namespace EPA\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use EPA\Domain\EPA;
use EPA\Domain\SelbstBewertung\SelbstBewertung;
use EPA\Domain\SelbstBewertung\SelbstBewertungsId;
use EPA\Domain\SelbstBewertung\SelbstBewertungsRepository;
use EPA\Domain\SelbstBewertung\SelbstBewertungsTyp;
use Studi\Domain\LoginHash;

final class DBSelbstBewertungsRepository implements SelbstBewertungsRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(SelbstBewertung $object): void {
        $this->abstractDelete($object);
    }

    public function add(SelbstBewertung $object): void {
        $this->abstractAdd($object);
    }

    public function byId(SelbstBewertungsId $id): ?SelbstBewertung {
        return $this->abstractById($id);
    }

    public function nextIdentity(): SelbstBewertungsId {
        return SelbstBewertungsId::fromInt($this->abstractNextIdentityAsInt());
    }

    /** @return SelbstBewertung[] */
    public function allLatestByStudiUndTyp(LoginHash $loginHash, SelbstBewertungsTyp $typ): array {
        /** @var SelbstBewertung[] $alleSelbstBewertungenNeueste */
        $alleSelbstBewertungenNeueste = [];
        /** @var SelbstBewertung[] $alleSelbstBewertungen */
        $alleSelbstBewertungen = $this->doctrineRepo->createQueryBuilder("selbstbewertung")
            ->andWhere("selbstbewertung.loginHash= :loginHash")
            ->setParameter("loginHash", $loginHash)
            ->andWhere("selbstbewertung.selbstBewertungsTyp.value = :typ")
            ->setParameter("typ", $typ->getValue())
            ->addOrderBy("selbstbewertung.epaBewertungsDatum.value", "DESC")
            ->getQuery()->execute();
        foreach ($alleSelbstBewertungen as $selbstbewertung) {
            $epaNummer = $selbstbewertung->getEpaBewertung()->getEpa()->getNummer();
            if (!isset($alleSelbstBewertungenNeueste[$epaNummer])
                || $selbstbewertung->getEpaBewertungsDatum()
                    ->istNeuerAls($alleSelbstBewertungenNeueste[$epaNummer]->getEpaBewertungsDatum())
            ) {
                $alleSelbstBewertungenNeueste[$epaNummer] = $selbstbewertung;
            }
        }
        return array_values($alleSelbstBewertungenNeueste);
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