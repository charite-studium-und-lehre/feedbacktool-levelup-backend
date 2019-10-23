<?php

namespace Studienfortschritt\Domain\Service;

use Pruefung\Domain\PruefungsRepository;
use Studi\Domain\StudiHash;
use Studienfortschritt\Domain\FortschrittsItem;
use Studienfortschritt\Domain\StudiMeilensteinRepository;
use StudiPruefung\Domain\StudiPruefungsRepository;

/** Vereint abgespeicherte Meilsteine und indirekt, durch Prüfungsteilnahmen, erworbene Fortschritts-Items */
class StudienFortschrittExportService
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

    /** return FortschrittsItem[] */
    public function alleFortschrittsItemsFuerStudi(StudiHash $studiHash): array {
        $alleItems = [];
        foreach ($this->studiMeilensteinRepository->allByStudiHash($studiHash) as $studiMeilenstein) {
            $alleItems[] = $studiMeilenstein->getMeilenstein();
            foreach ($studiMeilenstein->getMeilenstein()->getImplizierteFortschrittsItems() as $item) {
                $alleItems[] = $studiMeilenstein->getMeilenstein();
            }

        }
        foreach ($this->studiPruefungsRepository->allByStudiHash($studiHash) as $studiPruefung) {
            if (!$studiPruefung->isBestanden()) {
                continue;
            }
            $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
            $meilenstein = FortschrittsItem::fromPruefung($pruefung, $studiPruefung->getId());
            if ($meilenstein) {
                $alleItems[] = $meilenstein;
            }
        }

        return $alleItems;

    }

}