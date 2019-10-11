<?php

namespace EPA\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use EPA\Domain\EPA;
use EPA\Domain\SelbstBewertung;
use EPA\Domain\SelbstBewertungsId;
use EPA\Domain\SelbstBewertungsRepository;
use EPA\Domain\SelbstBewertungsTyp;
use Studi\Domain\LoginHash;

/** @method SelbstBewertung[] all() */
final class FileBasedSimpleSelbstBewertungsRepository extends AbstractCommonRepository implements SelbstBewertungsRepository
{
    use FileBasedRepoTrait;

    public function byId(SelbstBewertungsId $id): ?SelbstBewertung {
        return $this->abstractById($id);
    }

    public function nextIdentity(): SelbstBewertungsId {
        return SelbstBewertungsId::fromString($this->abstractNextIdentity());
    }

    public function allLatestByStudiUndTyp(LoginHash $loginHash, SelbstBewertungsTyp $typ): array {
        $gefundeneBewertungen = [];
        foreach ($this->all() as $bewertung) {
            if (!$bewertung->getLoginHash()->equals($loginHash)
                || !$bewertung->getSelbstBewertungsTyp()->equals($typ)) {
                continue;
            }
            $epaNummer = $bewertung->getEpaBewertung()->getEpa()->getNummer();
            if (!isset($gefundeneBewertungen[$epaNummer])) {
                $gefundeneBewertungen[$epaNummer] = $bewertung;
            }
            if ($bewertung->getEpaBewertungsDatum()
                ->istNeuerAls($gefundeneBewertungen[$epaNummer]->getEpaBewertungsDatum())) {
                $gefundeneBewertungen[$epaNummer] = $bewertung;
            }
        }

        return array_values($gefundeneBewertungen);
    }

    /** @return SelbstBewertung[] */
    public function allByStudi(LoginHash $loginHash): array {
        $resultArray = [];
        foreach ($this->all() as $bewertung) {
            if ($bewertung->getLoginHash()->equals($loginHash)) {
                $resultArray[] = $bewertung;
            }
        }

        return $resultArray;
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
