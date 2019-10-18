<?php

namespace StudiPruefung\Domain\Service;

use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItemRepository;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\Wertung\ProzentWertung;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\RichtigFalschWeissnichtWertung;

/** @TODO Tests */
class ItemWertungDurchschnittPersistenzService
{
    /** @var ItemWertungsRepository */
    private $itemWertungsRepository;

    /** @var PruefungsItemRepository */
    private $pruefungsItemRepository;

    public function __construct(
        ItemWertungsRepository $itemWertungsRepository,
        PruefungsItemRepository $pruefungsItemRepository
    ) {
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->pruefungsItemRepository = $pruefungsItemRepository;
    }

    public function berechneUndPersistiereDurchschnitt(): void {
        $allePruefungsItems = $this->pruefungsItemRepository->all();
        foreach($allePruefungsItems as $pruefungsItem) {
            $itemWertungen = $this->itemWertungsRepository->allByPruefungssItemId($pruefungsItem->getId());
            if (!$itemWertungen) {
                continue;
            }
            $wertungen = [];
            foreach($itemWertungen as $itemWertung) {
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