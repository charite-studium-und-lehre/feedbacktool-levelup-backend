<?php

namespace StudiPruefung\Domain\Service;

use Pruefung\Domain\PruefungsId;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\StudiPruefungsWertungRepository;
use Wertung\Domain\Wertung\ProzentWertung;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\RichtigFalschWeissnichtWertung;

/** @TODO Tests */
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

    public function berechneUndPersistiereGesamtDurchschnitt(): void {
        $alleItemWertungen = $this->itemWertungsRepository->all();
        $kohortenWertungen = [];
        foreach ($alleItemWertungen as $itemWertung) {
            $studiPruefungsId = $itemWertung->getStudiPruefungsId();
            $pruefungsWertung = $this->studiPruefungsWertungRepository->byStudiPruefungsId($studiPruefungsId);
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
        echo ".";
        $this->studiPruefungsWertungRepository->flush();
    }
}