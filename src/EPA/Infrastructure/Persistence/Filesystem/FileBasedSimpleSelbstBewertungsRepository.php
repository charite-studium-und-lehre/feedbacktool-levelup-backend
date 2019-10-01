<?php

namespace EPA\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use EPA\Domain\SelbstBewertung;
use EPA\Domain\SelbstBewertungsId;
use EPA\Domain\SelbstBewertungsRepository;
use EPA\Domain\SelbstBewertungsTyp;
use Studi\Domain\StudiHash;

/** @method SelbstBewertung[] all()   */
final class FileBasedSimpleSelbstBewertungsRepository extends AbstractCommonRepository implements SelbstBewertungsRepository
{
    use FileBasedRepoTrait;

    public function byId(SelbstBewertungsId $id): ?SelbstBewertung {
        return $this->abstractById($id);
    }

    public function nextIdentity(): SelbstBewertungsId {
        return SelbstBewertungsId::fromString($this->abstractNextIdentity());
    }

    public function latestByStudiUndTyp(StudiHash $studiHash, SelbstBewertungsTyp $typ): ?SelbstBewertung {
        $gefundeneBewertung = NULL;
        foreach ($this->all() as $bewertung) {
            if (!$bewertung->getStudiHash()->equals($studiHash)
                || !$bewertung->getSelbstBewertungsTyp()->equals($typ)) {
                continue;
            }
            if (!$gefundeneBewertung) {
                $gefundeneBewertung = $bewertung;
            }
            if ($bewertung->getEpaBewertungsDatum()->istNeuerAls($gefundeneBewertung->getEpaBewertungsDatum())) {
                $gefundeneBewertung = $bewertung;
            }
        }
        return $gefundeneBewertung;
    }

    /** @return SelbstBewertung[] */
    public function allByStudi(StudiHash $studiHash): array {
        $resultArray = [];
        foreach ($this->all() as $bewertung) {
            if ($bewertung->getStudiHash()->equals($studiHash)) {
                $resultArray[] = $bewertung;
            }
        }
        return $resultArray;
    }
}
