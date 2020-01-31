<?php

namespace StudiPruefung\Domain\Service;

use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Domain\PruefungsRepository;
use Wertung\Domain\ItemWertungsRepository;

/** @TODO Tests */
class ItemWertungDurchschnittPersistenzService
{
    private PruefungsRepository $pruefungsRepository;

    private ItemWertungsRepository $itemWertungsRepository;

    private PruefungsItemRepository $pruefungsItemRepository;

    public function __construct(
        PruefungsRepository $pruefungsRepository,
        ItemWertungsRepository $itemWertungsRepository,
        PruefungsItemRepository $pruefungsItemRepository
    ) {
        $this->pruefungsRepository = $pruefungsRepository;
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->pruefungsItemRepository = $pruefungsItemRepository;
    }

    public function berechneUndPersistiereDurchschnitt(PruefungsId $pruefungsId): void {
        $pruefung = $this->pruefungsRepository->byId($pruefungsId);
        $allePruefungsItems = $this->pruefungsItemRepository->allByPruefungsId($pruefung->getId());
        foreach ($allePruefungsItems as $pruefungsItem) {
            $itemWertungen = $this->itemWertungsRepository->allByPruefungssItemId($pruefungsItem->getId());
            if (!$itemWertungen) {
                echo "c";
                continue;
            }
            $wertungen = [];
            foreach ($itemWertungen as $itemWertung) {
                $wertungen[] = $itemWertung->getWertung();
            }
            $ersteWertung = $itemWertungen[0];
            $durchschnittsWertung = $ersteWertung->getWertung()::getDurchschnittsWertung($wertungen);
            foreach ($itemWertungen as $itemWertung) {
                $itemWertung->setKohortenWertung($durchschnittsWertung);
            }
        }
        $this->itemWertungsRepository->flush();
    }
}