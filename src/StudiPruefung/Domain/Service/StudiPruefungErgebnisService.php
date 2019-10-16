<?php

namespace StudiPruefung\Domain\Service;

use Pruefung\Domain\Pruefung;
use StudiPruefung\Domain\StudiPruefungsId;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\StudiPruefungsWertungRepository;
use Wertung\Domain\Wertung\PunktWertung;

class StudiPruefungErgebnisService
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

    public function getErgebnisAlsJsonArray(Pruefung $pruefung, StudiPruefungsId $studiPruefungsId): array {
        $pruefungsWertung = $this->studiPruefungsWertungRepository->byStudiPruefungsId($studiPruefungsId);
        if (!$pruefungsWertung){
            return [];
        }
        if ($pruefung->getFormat()->isMc()) {
            return [
                "ergebnisPunkte"  => $pruefungsWertung->getGesamtErgebnis()
                    ->getPunktWertung()->getPunktzahl()->getValue(),
                "gesamtPunktzahl" => $pruefungsWertung->getGesamtErgebnis()
                    ->getPunktWertung()
                    ->getSkala()->getMaxPunktzahl()->getValue(),
                "bestehensGrenze" => $pruefungsWertung->getBestehensGrenze()
                    ->getPunktWertung()->getPunktzahl()->getValue(),
                "durchschnitt"    => $pruefungsWertung->getKohortenWertung()
                    ? $pruefungsWertung->getKohortenWertung()->getPunktWertung()->getPunktzahl()->getValue()
                    : NULL,
            ];
        } elseif ($pruefung->getFormat()->isStation()) {
            return ["TODO" => "TODO"];
        }

    }

    private function getStudiErgebnisPunktWertungFloat(StudiPruefungsId $studiPruefungsId): ?float {
        $pruefungsWertung = $this->getStudiPruefungsWertung($studiPruefungsId);
        if (!$pruefungsWertung) {
            return NULL;
        }

        return $pruefungsWertung->getGesamtErgebnis()->getPunktWertung()
            ->getPunktzahl()->getValue();
    }

    private function getGesamtpunktzahlFloat(StudiPruefungsId $studiPruefungsId): ?float {
        $pruefungsWertung = $this->getStudiPruefungsWertung($studiPruefungsId);
        if (!$pruefungsWertung) {
            return NULL;
        }

        return $pruefungsWertung->getGesamtErgebnis()->getPunktWertung()
            ->getSkala()->getMaxPunktzahl()->getValue();
    }

    private function getBestehensGrenzePunktzahlFloat(StudiPruefungsId $studiPruefungsId): ?float {
        $pruefungsWertung = $this->getStudiPruefungsWertung($studiPruefungsId);
        if (!$pruefungsWertung) {
            return NULL;
        }

        return $pruefungsWertung->getBestehensGrenze()->getPunktWertung()
            ->getPunktzahl()->getValue();
    }

    /**
     * @param StudiPruefungsId $studiPruefungsId
     * @return \Wertung\Domain\StudiPruefungsWertung|null
     */
    private function getStudiPruefungsWertung(StudiPruefungsId $studiPruefungsId) {
        $pruefungsWertung = $this->studiPruefungsWertungRepository
            ->byStudiPruefungsId($studiPruefungsId);

        return $pruefungsWertung;
    }

}