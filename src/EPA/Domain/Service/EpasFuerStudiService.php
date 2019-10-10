<?php

namespace EPA\Domain\Service;

use EPA\Domain\SelbstBewertungsRepository;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiRepository;

class EpasFuerStudiService
{
    /** @var StudiRepository */
    private $studiRepository;

    /** @var SelbstBewertungsRepository */
    private $selbstBewertungsRepository;

    public function __construct(
        StudiRepository $studiRepository,
        SelbstBewertungsRepository $selbstBewertungsRepository,
        LoginHash $loginHash
    ) {
        $this->studiRepository = $studiRepository;
        $this->selbstBewertungsRepository = $selbstBewertungsRepository;
    }

    public function getEpaStudiData() {
        $studi = $this->studiRepository->byHash();
    }

}