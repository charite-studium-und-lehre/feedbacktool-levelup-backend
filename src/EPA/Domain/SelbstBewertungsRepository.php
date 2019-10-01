<?php

namespace EPA\Domain;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;
use Studi\Domain\StudiHash;

interface SelbstBewertungsRepository extends DDDRepository, FlushableRepository
{
    public function add(SelbstBewertung $object): void;

    public function byId(SelbstBewertungsId $id): ?SelbstBewertung;

    /** @return SelbstBewertung[] */
    public function all(): array;

    public function delete(SelbstBewertung $object): void;

    public function nextIdentity(): SelbstBewertungsId;

    public function latestByStudiUndTyp(StudiHash $studiHash, SelbstBewertungsTyp $typ): ?SelbstBewertung;

    /** @return SelbstBewertung[] */
    public function allByStudi(StudiHash $studiHash): array;

}
