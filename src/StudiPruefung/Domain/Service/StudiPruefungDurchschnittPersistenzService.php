<?php

namespace StudiPruefung\Domain\Service;

use Pruefung\Domain\PruefungsRepository;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Wertung\Domain\StudiPruefungsWertungRepository;
use Wertung\Domain\Wertung\ProzentWertung;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\RichtigFalschWeissnichtWertung;

/** @TODO Tests */
class StudiPruefungDurchschnittPersistenzService
{
    /** @var PruefungsRepository */
    private $pruefungsRepository;

    /** @var StudiPruefungsWertungRepository */
    private $studiPruefungsWertungRepository;

    /** @var StudiPruefungsRepository */
    private $studiPruefungsRepository;

    public function __construct(
        PruefungsRepository $pruefungsRepository,
        StudiPruefungsWertungRepository $studiPruefungsWertungRepository,
        StudiPruefungsRepository $studiPruefungsRepository
    ) {
        $this->pruefungsRepository = $pruefungsRepository;
        $this->studiPruefungsWertungRepository = $studiPruefungsWertungRepository;
        $this->studiPruefungsRepository = $studiPruefungsRepository;
    }

    public function berechneUndPersistiereGesamtDurchschnitt(): void {
        $allePruefungen = $this->pruefungsRepository->all();
        foreach ($allePruefungen as $pruefung) {
            $alleGesamtWertungen = [];
            $alleStudiPruefungsWertungen = [];
            $alleStudiPruefungen = $this->studiPruefungsRepository->allByPruefungsId($pruefung->getId());
            foreach ($alleStudiPruefungen as $studiPruefung) {
                $studiPruefungsWertung = $this->studiPruefungsWertungRepository
                    ->byStudiPruefungsId($studiPruefung->getId());
                if (!$studiPruefungsWertung) {
                    continue;
                }
                $alleStudiPruefungsWertungen[] = $studiPruefungsWertung;
                $alleGesamtWertungen[] = $studiPruefungsWertung->getGesamtErgebnis();
            }
            if ($alleGesamtWertungen && ($alleGesamtWertungen[0] instanceof PunktWertung)) {
                $kohortenWertung = PunktWertung::getDurchschnittsWertung($alleGesamtWertungen);
            } elseif ($alleGesamtWertungen && ($alleGesamtWertungen[0] instanceof ProzentWertung)) {
                $kohortenWertung = ProzentWertung::getDurchschnittsWertung($alleGesamtWertungen);
            } elseif ($alleGesamtWertungen && ($alleGesamtWertungen[0] instanceof RichtigFalschWeissnichtWertung)) {
                $kohortenWertung = RichtigFalschWeissnichtWertung::getDurchschnittsWertung($alleGesamtWertungen);
            }
            foreach ($alleStudiPruefungsWertungen as $studiPruefungsWertung) {
                $studiPruefungsWertung->setKohortenWertung($kohortenWertung);
            }
            echo ".";
            $this->studiPruefungsWertungRepository->flush();

        }
   }
}