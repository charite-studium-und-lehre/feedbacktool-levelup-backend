<?php

namespace StudiPruefung\Domain\Service;

use Pruefung\Domain\PruefungsId;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\StudiPruefungsWertungRepository;
use Wertung\Domain\Wertung\PunktWertung;

class StudiPruefungDurchschnittPersistenzService
{
    /** @var ItemWertungsRepository */
    private $itemWertungsRepository;

    /** @var StudiPruefungsWertungRepository */
    private $studiPruefungsWertungRepository;

    /** @var StudiPruefungsRepository */
    private $studiPruefungsRepository;

    public function __construct(
        ItemWertungsRepository $itemWertungsRepository,
        StudiPruefungsWertungRepository $studiPruefungsWertungRepository,
        StudiPruefungsRepository $studiPruefungsRepository
    ) {
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->studiPruefungsWertungRepository = $studiPruefungsWertungRepository;
        $this->studiPruefungsRepository = $studiPruefungsRepository;
    }

    public function berechneUndPersistiereDurchschnitt(PruefungsId $pruefungsId): void {

        $alleStudiPruefungen = $this->studiPruefungsRepository->allByPruefungsId($pruefungsId);
        $kohortenWertungen = [];
        foreach ($alleStudiPruefungen as $studiPruefung) {
            $pruefungsWertung = $this->studiPruefungsWertungRepository->byStudiPruefungsId($studiPruefung->getId());
            if (!$pruefungsWertung) {
                continue;
            }
            $kohortenWertungen[] = $pruefungsWertung->getGesamtErgebnis();
        }
        if ($kohortenWertungen && ($kohortenWertungen[0] instanceof PunktWertung)) {
            $kohortenWertung = PunktWertung::getDurchschnittsWertung($kohortenWertungen);
        }
        foreach ($alleStudiPruefungen as $studiPruefung) {
            $pruefungsWertung = $this->studiPruefungsWertungRepository->byStudiPruefungsId($studiPruefung->getId());
            if (!$pruefungsWertung) {
                continue;
            }
            $pruefungsWertung->setKohortenWertung($kohortenWertung);
        }
        $this->studiPruefungsWertungRepository->flush();
    }
}