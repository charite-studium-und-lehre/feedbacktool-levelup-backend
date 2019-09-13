<?php

namespace StudiMeilenstein\Domain\Service;

use Studi\Domain\StudiHash;
use StudiMeilenstein\Domain\StudiMeilensteinRepository;
use StudiPruefung\Domain\StudiPruefungsRepository;

/** Vereint abgespeicherte Meilensteine und indirekt, durch Prüfungsteilnahmen, erworbene Meilensteine */
class MeilensteinExportService
{
    /** @var StudiMeilensteinRepository */
    private $studiMeilensteinRepository;

    /** @var StudiPruefungsRepository */
    private $studiPruefungsRepository;

    public function __construct(
        StudiMeilensteinRepository $studiMeilensteinRepository,
        StudiPruefungsRepository $studiPruefungsRepository
    ) {
        $this->studiMeilensteinRepository = $studiMeilensteinRepository;
        $this->studiPruefungsRepository = $studiPruefungsRepository;
    }

    /** return array<int> */
    public function alleMeilensteinCodesFuerStudi(StudiHash $studiHash): array {
        $meilensteine = $this->studiMeilensteinRepository->allByStudiHash($studiHash);
        $studiCodes = [];
        foreach ($meilensteine as $meilenstein) {
            $studiCodes[] = $meilenstein->getMeilenstein()->getCode();
        }
        foreach ($this->studiPruefungsRepository->allByStudiHash($studiHash)) {

        }

        return $studiCodes;

    }

}