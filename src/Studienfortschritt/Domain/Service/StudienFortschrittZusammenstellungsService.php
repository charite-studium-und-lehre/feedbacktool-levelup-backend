<?php

namespace Studienfortschritt\Domain\Service;

use Pruefung\Domain\PruefungsRepository;
use Studi\Domain\StudiHash;
use Studienfortschritt\Domain\FortschrittsItem;
use Studienfortschritt\Domain\StudiMeilensteinRepository;
use StudiPruefung\Domain\StudiPruefungsRepository;

/**
 * Vereint abgespeicherte Meilsteine und indirekt, durch Prüfungsteilnahmen, erworbene Fortschritts-Items
 * @todo Test
 */
class StudienFortschrittZusammenstellungsService
{
    private StudiMeilensteinRepository $studiMeilensteinRepository;

    private StudiPruefungsRepository $studiPruefungsRepository;

    private PruefungsRepository $pruefungsRepository;

    public function __construct(
        StudiMeilensteinRepository $studiMeilensteinRepository,
        StudiPruefungsRepository $studiPruefungsRepository,
        pruefungsRepository $pruefungsRepository
    ) {
        $this->studiMeilensteinRepository = $studiMeilensteinRepository;
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->pruefungsRepository = $pruefungsRepository;
    }

    /** @return FortschrittsItem[] */
    public function alleFortschrittsItemsFuerStudi(StudiHash $studiHash): array {
        $alleItems = [];
        foreach ($this->studiMeilensteinRepository->allByStudiHash($studiHash) as $studiMeilenstein) {
            $alleItems[] = $studiMeilenstein->getFortschrittsItem();
            foreach ($studiMeilenstein->getFortschrittsItem()->getImplizierteFortschrittsItems() as $item) {
                $alleItems[] = $item;
            }
        }
        foreach ($this->studiPruefungsRepository->allByStudiHash($studiHash) as $studiPruefung) {
            if (!$studiPruefung->isBestanden()) {
                continue;
            }
            $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
            $fortschrittsItem = FortschrittsItem::fromPruefung($pruefung, $studiPruefung->getId());
            if ($fortschrittsItem) {
                $alleItems[] = $fortschrittsItem;
            }
        }

        return $alleItems;

    }

}