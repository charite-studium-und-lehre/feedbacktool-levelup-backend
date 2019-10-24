<?php

namespace StudiPruefung\Domain\Service;

use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTyp;
use Cluster\Domain\ClusterZuordnungsService;
use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Domain\PruefungsRepository;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsId;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\StudiPruefungsWertungRepository;

class StudiPruefungErgebnisService
{
    /** @var StudiPruefungsWertungRepository */
    private $studiPruefungsWertungRepository;

    /** @var StudiPruefungsRepository */
    private $studiPruefungsRepository;

    /** @var PruefungsRepository */
    private $pruefungsRepository;

    /** @var PruefungsItemRepository */
    private $pruefungsItemRepository;

    /** @var ItemWertungsRepository */
    private $itemWertungsRepository;

    /** @var ClusterZuordnungsService */
    private $clusterZuordnungsService;

    /** @var ClusterRepository */
    private $clusterRepository;

    public function __construct(
        StudiPruefungsWertungRepository $studiPruefungsWertungRepository,
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsRepository $pruefungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        ItemWertungsRepository $itemWertungsRepository,
        ClusterZuordnungsService $clusterZuordnungsService,
        ClusterRepository $clusterRepository
    ) {
        $this->studiPruefungsWertungRepository = $studiPruefungsWertungRepository;
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->pruefungsRepository = $pruefungsRepository;
        $this->pruefungsItemRepository = $pruefungsItemRepository;
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->clusterZuordnungsService = $clusterZuordnungsService;
        $this->clusterRepository = $clusterRepository;
    }

    public function getErgebnisAlsJsonArray(StudiPruefung $studiPruefung): array {
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
        $pruefungsWertung = $this->studiPruefungsWertungRepository->byStudiPruefungsId($studiPruefung->getId());
        if (!$pruefungsWertung) {
            return [];
        }
        if ($pruefung->getFormat()->isMc()) {
            return [
                "ergebnisPunktzahl"        => $pruefungsWertung->getGesamtErgebnis()
                    ->getPunktWertung()->getPunktzahl()->getValue(),
                "durchschnittsPunktzahl"   => $pruefungsWertung->getKohortenWertung()
                    ? $pruefungsWertung->getKohortenWertung()->getPunktWertung()->getPunktzahl()->getValue()
                    : NULL,
                "maximalPunktzahl"         => $pruefungsWertung->getGesamtErgebnis()
                    ->getPunktWertung()->getSkala()->getMaxPunktzahl()->getValue(),
                "bestehensgrenzePunktzahl" => $pruefungsWertung->getBestehensGrenze()
                    ->getPunktWertung()->getPunktzahl()->getValue(),
            ];
        } elseif ($pruefung->getFormat()->isStation()) {
            return [
                "ergebnisProzentzahl"     => $pruefungsWertung->getGesamtErgebnis()
                    ->getProzentWertung()->getProzentzahl()->getValue(),
                "durchschnittProzentzahl" => $pruefungsWertung->getKohortenWertung()
                    ? $pruefungsWertung->getKohortenWertung()->getProzentWertung()->getProzentzahl()->getValue()
                    : NULL,
            ];
        } elseif ($pruefung->getFormat()->isPTM()) {
            return [
                "ergebnisRichtigPunktzahl"        => $pruefungsWertung->getGesamtErgebnis()
                    ->getRichtigFalschWeissnichtWertung()->getPunktzahlRichtig()->getValue(),
                "ergebnisFalschPunktzahl"         => $pruefungsWertung->getGesamtErgebnis()
                    ->getRichtigFalschWeissnichtWertung()->getPunktzahlFalsch()->getValue(),
                "ergebnisWeissnichtPunktzahl"     => $pruefungsWertung->getGesamtErgebnis()
                    ->getRichtigFalschWeissnichtWertung()->getPunktzahlWeissnicht()->getValue(),
                "maximalPunktzahl"                => $pruefungsWertung->getGesamtErgebnis()
                    ->getRichtigFalschWeissnichtWertung()->getGesamtPunktzahl()->getValue(),
                "durchschnittRichtigPunktzahl"    => $pruefungsWertung->getKohortenWertung()
                    ->getRichtigFalschWeissnichtWertung()->getPunktzahlRichtig()->getValue(),
                "durchschnittFalschPunktzahl"     => $pruefungsWertung->getKohortenWertung()
                    ->getRichtigFalschWeissnichtWertung()->getPunktzahlFalsch()->getValue(),
                "durchschnittWeissnichtPunktzahl" => $pruefungsWertung->getKohortenWertung()
                    ->getRichtigFalschWeissnichtWertung()->getPunktzahlWeissnicht()->getValue(),

            ];
        } else {
            return $pruefung->getFormat()->getValue();
        }
    }

    public function getErgebnisDetailsAlsJsonArray(StudiPruefung $studiPruefung): array {
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
        if ($pruefung->getFormat()->isMc()) {
            return $this->getMCErgebnisDetailsAlsJsonArray($studiPruefung);
        } elseif ($pruefung->getFormat()->isStation()) {
            return [];
        } elseif ($pruefung->getFormat()->isPTM()) {
            return [];
        }
        return [];
    }

    private function getStationsErgebnisDetailsAlsJsonArray(StudiPruefung $studiPruefung): array {
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
        $itemWertungen = $this->itemWertungsRepository->allByStudiPruefungsId($studiPruefung->getId());
        if (!$pruefung->getFormat()->isStation()) {
            return [];
        }
    }

    private function getPTMErgebnisDetailsAlsJsonArray(StudiPruefung $studiPruefung): array {
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
        $itemWertungen = $this->itemWertungsRepository->allByStudiPruefungsId($studiPruefung->getId());
        if (!$pruefung->getFormat()->isPTM()) {
            return [];
        }

        $itemsNachFach = [];
        $itemsNachModul = [];
        foreach ($itemWertungen as $itemWertung) {
            $clusterIds = $this->clusterZuordnungsService->getVorhandeneClusterIdsNachTyp(
                $itemWertung->getPruefungsItemId(),
                ClusterTyp::getFachTyp()
            );
            if ($clusterIds) {
                $fachClusterId = $clusterIds[0];
                $itemsNachFach[$fachClusterId->getValue()][] = $itemWertung;
            }
        }

        $fachAggregate = [];
        foreach ($itemsNachFach as $clusterId => $itemWertungen) {
            $fach = $this->clusterRepository->byId(ClusterId::fromInt($clusterId));
            $alleMeineWertungen = [];
            $alleKohortenWertungen = [];
            foreach ($itemWertungen as $itemWertung) {
                $alleMeineWertungen[] = $itemWertung->getWertung();
                $alleKohortenWertungen[] = $itemWertung->getKohortenWertung();
            }
            $meinDurchschnitt = $itemWertungen[0]->getWertung()::getDurchschnittsWertung($alleMeineWertungen);
            $kohortenDurchschnitt = $itemWertungen[0]->getWertung()::getDurchschnittsWertung($alleKohortenWertungen);
            $fachChar = substr($fach->getCode()->getValue(), 0, 1);

            switch ($fachChar) {
                case "F":
                    $gruppe = "Klinische Fächer";
                    break;
                case "Q":
                    $gruppe = "Querschnittsfächer";
                    break;
                case "S":
                    $gruppe = "Vorklinische Fächer";
                    break;
                default:
                    $gruppe = "Andere";
            }
            $fachAggregate[] = [
                "code"                   => $fach->getCode()->getValue(),
                "titel"                  => $fach->getTitel()->getValue(),
                "gruppe"                 => $gruppe,
                "ergebnisPunktzahl"      => $meinDurchschnitt->getPunktWertung()->getPunktzahl()->getValue(),
                "durchschnittsPunktzahl" => $kohortenDurchschnitt->getPunktWertung()->getPunktzahl()->getValue(),
                "maximalPunktzahl"       => $meinDurchschnitt->getPunktWertung()
                    ->getSkala()
                    ->getMaxPunktzahl()
                    ->getValue(),
            ];
        }
    }

    private function getMCErgebnisDetailsAlsJsonArray(StudiPruefung $studiPruefung): array {
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
        $itemWertungen = $this->itemWertungsRepository->allByStudiPruefungsId($studiPruefung->getId());
        if (!$pruefung->getFormat()->isMc()) {
            return [];
        }

        $itemsNachFach = [];
        $itemsNachModul = [];
        foreach ($itemWertungen as $itemWertung) {
            $clusterIds = $this->clusterZuordnungsService->getVorhandeneClusterIdsNachTyp(
                $itemWertung->getPruefungsItemId(),
                ClusterTyp::getFachTyp()
            );
            if ($clusterIds) {
                $fachClusterId = $clusterIds[0];
                $itemsNachFach[$fachClusterId->getValue()][] = $itemWertung;
            }
        }

        foreach ($itemWertungen as $itemWertung) {
            $clusterIds = $this->clusterZuordnungsService->getVorhandeneClusterIdsNachTyp(
                $itemWertung->getPruefungsItemId(),
                ClusterTyp::getModulTyp()
            );
            if ($clusterIds) {
                $modulClusterId = $clusterIds[0];
                $itemsNachModul[$modulClusterId->getValue()][] = $itemWertung;
            }
        }

        $fachAggregate = [];
        foreach ($itemsNachFach as $clusterId => $itemWertungen) {
            $fach = $this->clusterRepository->byId(ClusterId::fromInt($clusterId));
            $alleMeineWertungen = [];
            $alleKohortenWertungen = [];
            foreach ($itemWertungen as $itemWertung) {
                $alleMeineWertungen[] = $itemWertung->getWertung();
                $alleKohortenWertungen[] = $itemWertung->getKohortenWertung();
            }
            $meineSumme = $itemWertungen[0]->getWertung()::getSummenWertung($alleMeineWertungen);
            $kohortenSumme = $itemWertungen[0]->getWertung()::getSummenWertung($alleKohortenWertungen);
            $fachChar = substr($fach->getCode()->getValue(), 0, 1);

            switch ($fachChar) {
                case "F":
                    $gruppe = "Klinische Fächer";
                    break;
                case "Q":
                    $gruppe = "Querschnittsfächer";
                    break;
                case "S":
                    $gruppe = "Vorklinische Fächer";
                    break;
                default:
                    $gruppe = "Andere";
            }
            $fachAggregate[] = [
                "code"                   => $fach->getCode()->getValue(),
                "titel"                  => $fach->getTitel()->getValue(),
                "gruppe"                 => $gruppe,
                "ergebnisPunktzahl"      => $meineSumme->getPunktWertung()->getPunktzahl()->getValue(),
                "durchschnittsPunktzahl" => $kohortenSumme->getPunktWertung()->getPunktzahl()->getValue(),
                "maximalPunktzahl"       => $meineSumme->getPunktWertung()
                    ->getSkala()
                    ->getMaxPunktzahl()
                    ->getValue(),
            ];
        }

        $modulAggregate = [];
        foreach ($itemsNachModul as $clusterId => $itemWertungen) {
            $modul = $this->clusterRepository->byId(ClusterId::fromInt($clusterId));
            $alleMeineWertungen = [];
            $alleKohortenWertungen = [];
            foreach ($itemWertungen as $itemWertung) {
                $alleMeineWertungen[] = $itemWertung->getWertung();
                $alleKohortenWertungen[] = $itemWertung->getKohortenWertung();
            }
            $meineSumme = $itemWertungen[0]->getWertung()::getDurchschnittsWertung($alleMeineWertungen);
            $kohortenSumme = $itemWertungen[0]->getWertung()::getDurchschnittsWertung($alleKohortenWertungen);

            $modulAggregate[] = [
                "code"                   => $modul->getCode()->getValue(),
                "titel"                  => $modul->getTitel()->getValue(),
                "ergebnisPunktzahl"      => $meineSumme->getPunktWertung()->getPunktzahl()->getValue(),
                "durchschnittsPunktzahl" => $kohortenSumme->getPunktWertung()->getPunktzahl()->getValue(),
                "maximalPunktzahl"       => $meineSumme->getPunktWertung()
                    ->getSkala()
                    ->getMaxPunktzahl()
                    ->getValue(),
            ];
        }

        // MC

        return [
            "faecher" => $fachAggregate,
            "module"  => $modulAggregate,
        ];
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