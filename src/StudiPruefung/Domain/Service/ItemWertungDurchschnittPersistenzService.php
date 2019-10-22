<?php

namespace StudiPruefung\Domain\Service;

use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Domain\PruefungsRepository;
use Wertung\Domain\ItemWertungsRepository;

/** @TODO Tests */
class ItemWertungDurchschnittPersistenzService
{
    /** @var PruefungsRepository */
    private $pruefungsRepository;

    /** @var ItemWertungsRepository */
    private $itemWertungsRepository;

    /** @var PruefungsItemRepository */
    private $pruefungsItemRepository;

    public function __construct(
        PruefungsRepository $pruefungsRepository,
        ItemWertungsRepository $itemWertungsRepository,
        PruefungsItemRepository $pruefungsItemRepository
    ) {
        $this->pruefungsRepository = $pruefungsRepository;
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->pruefungsItemRepository = $pruefungsItemRepository;
    }

    public function berechneUndPersistiereDurchschnitt(): void {
        $allePruefungen = $this->pruefungsRepository->all();
        foreach ($allePruefungen as $pruefung) {

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
                $durchschnittsWertung = $ersteWertung->getWertung()
                    ::getDurchschnittsWertung($wertungen);
                foreach ($itemWertungen as $itemWertung) {
                    $itemWertung->setKohortenWertung($durchschnittsWertung);
                }
            }
            $this->itemWertungsRepository->flush();
            echo ".";
        }
    }
}