<?php

namespace EPA\Domain\SelbstBewertung;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;
use EPA\Domain\EPA;
use Studi\Domain\LoginHash;

interface SelbstBewertungsRepository extends DDDRepository, FlushableRepository
{
    public function add(SelbstBewertung $object): void;

    public function byId(SelbstBewertungsId $id): ?SelbstBewertung;

    /** @return SelbstBewertung[] */
    public function all(): array;

    public function delete(SelbstBewertung $object): void;

    public function nextIdentity(): SelbstBewertungsId;

    /** @return SelbstBewertung[] */
    public function allLatestByStudiUndTyp(LoginHash $loginHash, SelbstBewertungsTyp $typ): array;

    /** @return SelbstBewertung[] */
    public function latestByStudiUndTypUndEpa(
        LoginHash $loginHash,
        SelbstBewertungsTyp $typ,
        EPA $epa
    ): ?SelbstBewertung;

    /** @return SelbstBewertung[] */
    public function allByStudi(LoginHash $loginHash): array;

}
