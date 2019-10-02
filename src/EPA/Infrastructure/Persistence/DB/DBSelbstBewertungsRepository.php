<?php

namespace EPA\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use EPA\Domain\SelbstBewertung;
use EPA\Domain\SelbstBewertungsId;
use EPA\Domain\SelbstBewertungsRepository;
use EPA\Domain\SelbstBewertungsTyp;
use Studi\Domain\StudiHash;

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

    public function latestByStudiUndTyp(StudiHash $studiHash, SelbstBewertungsTyp $typ): ?SelbstBewertung {
        return $this->doctrineRepo->findOneBy(
            [
                "studiHash"                 => $studiHash,
                "selbstBewertungsTyp.value" => $typ->getValue(),
            ],
            [
                "epaBewertungsDatum.value" => "DESC",
            ]
        );
    }

    /** @return SelbstBewertung[] */
    public function allByStudi(StudiHash $studiHash): array {
        return $this->doctrineRepo->findBy(
            [
                "studiHash" => $studiHash,
            ]
        );
    }
}