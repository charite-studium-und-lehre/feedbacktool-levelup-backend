<?php

namespace StudiPruefung\Domain\Service;

use Pruefung\Domain\PruefungsId;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\Wertung\ProzentWertung;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\RichtigFalschWeissnichtWertung;

/** @TODO Tests */
class ItemWertungDurchschnittPersistenzService
{
    /** @var ItemWertungsRepository */
    private $itemWertungsRepository;

    public function __construct(ItemWertungsRepository $itemWertungsRepository) {
        $this->itemWertungsRepository = $itemWertungsRepository;
    }

    public function berechneUndPersistiereDurchschnitt(PruefungsId $pruefungsId): void {
        $alleItemWertungen = $this->itemWertungsRepository->all();
        $kohortenWertungen = [];
        foreach ($alleItemWertungen as $studiPruefung) {
            $pruefungsWertung = $this->studiPruefungsWertungRepository->byStudiPruefungsId($studiPruefung->getId());
            if (!$pruefungsWertung) {
                continue;
            }
            $kohortenWertungen[] = $pruefungsWertung->getGesamtErgebnis();
        }
        if ($kohortenWertungen && ($kohortenWertungen[0] instanceof PunktWertung)) {
            $kohortenWertung = PunktWertung::getDurchschnittsWertung($kohortenWertungen);
        } elseif ($kohortenWertungen && ($kohortenWertungen[0] instanceof ProzentWertung)) {
            $kohortenWertung = ProzentWertung::getDurchschnittsWertung($kohortenWertungen);
        } elseif ($kohortenWertungen && ($kohortenWertungen[0] instanceof RichtigFalschWeissnichtWertung)) {
            $kohortenWertung = RichtigFalschWeissnichtWertung::getDurchschnittsWertung($kohortenWertungen);
        }
        foreach ($alleItemWertungen as $studiPruefung) {
            $pruefungsWertung = $this->studiPruefungsWertungRepository->byStudiPruefungsId($studiPruefung->getId());
            if (!$pruefungsWertung) {
                continue;
            }
            $pruefungsWertung->setKohortenWertung($kohortenWertung);
        }
        $this->studiPruefungsWertungRepository->flush();
    }
}