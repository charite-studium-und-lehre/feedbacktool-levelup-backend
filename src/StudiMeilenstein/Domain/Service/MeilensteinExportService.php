<?php

namespace StudiMeilenstein\Domain\Service;

use Pruefung\Domain\PruefungsRepository;
use Studi\Domain\StudiHash;
use StudiMeilenstein\Domain\Meilenstein;
use StudiMeilenstein\Domain\StudiMeilensteinRepository;
use StudiPruefung\Domain\StudiPruefungsRepository;

/** Vereint abgespeicherte Meilensteine und indirekt, durch Prüfungsteilnahmen, erworbene Meilensteine */
class MeilensteinExportService
{
    /** @var StudiMeilensteinRepository */
    private $studiMeilensteinRepository;

    /** @var StudiPruefungsRepository */
    private $studiPruefungsRepository;

    /** @var PruefungsRepository */
    private $pruefungsRepository;

    public function __construct(
        StudiMeilensteinRepository $studiMeilensteinRepository,
        StudiPruefungsRepository $studiPruefungsRepository,
        pruefungsRepository $pruefungsRepository
    ) {
        $this->studiMeilensteinRepository = $studiMeilensteinRepository;
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->pruefungsRepository = $pruefungsRepository;
    }

    /** return Meilenstein[] */
    public function alleMeilensteineFuerStudi(StudiHash $studiHash): array {
        $alleMeilensteine = [];
        foreach ($this->studiMeilensteinRepository->allByStudiHash($studiHash) as $meilenstein) {
            $alleMeilensteine[] = $meilenstein->getMeilenstein();
        }
        foreach ($this->studiPruefungsRepository->allByStudiHash($studiHash) as $studiPruefung) {
            if (!$studiPruefung->isBestanden()) {
                continue;
            }
            $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
            $meilenstein = Meilenstein::fromPruefung($pruefung);
            if ($meilenstein) {
                $alleMeilensteine[] = $meilenstein;
            }
        }

        return $alleMeilensteine;

    }

}