<?php

namespace StudiPruefung\Domain\Service;

use Cluster\Domain\Cluster;
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
use Wertung\Domain\Wertung\RichtigFalschWeissnichtWertung;

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

        $gesamtErgebnis = $this->getStudiPruefungGesamtWertung($studiPruefung);
        $einzelErgebnisse = $this->getErgebnisDetailsAlsJsonArray($studiPruefung);
        $pruefungsPeriode = $pruefung->getPruefungsPeriode();
        $returnArray = [
            "name"             => $pruefung->getName(),
            "typ"              => $pruefung->getFormat()->getCode(),
            "format"           => $pruefung->getFormat()->getFormatAbstrakt(),
            "studiPruefungsId" => $studiPruefung->getId()->getValue(),
            "zeitsemester"     => $pruefungsPeriode->getZeitsemester()->getStandardStringLesbar(),
            "periodeCode"      => $pruefungsPeriode->toInt(),
            "periodeText"      => $pruefungsPeriode->getPeriodeBeschreibung(),
            "gesamtErgebnis"   => $gesamtErgebnis,
        ];
        $returnArray = $returnArray + $einzelErgebnisse;

        return $returnArray;
    }

    private function getErgebnisDetailsAlsJsonArray(StudiPruefung $studiPruefung): array {
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
        if ($pruefung->getFormat()->isMc()) {
            return $this->getMCErgebnisDetailsAlsJsonArray($studiPruefung);
        } elseif ($pruefung->getFormat()->isStation()) {
            return [];
        } elseif ($pruefung->getFormat()->isPTM()) {
            return $this->getPTMErgebnisDetailsAlsJsonArray($studiPruefung);
        }

        return [];
    }

    private function getStudiPruefungGesamtWertung(StudiPruefung $studiPruefung): array {
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
        $pruefungsWertung = $this->studiPruefungsWertungRepository->byStudiPruefungsId($studiPruefung->getId());
        if (!$pruefungsWertung) {
            return [];
        }
        if ($pruefung->getFormat()->isMc()) {
            $kohortenWertungen = [];
            $alleStudiPruefungen = $this->studiPruefungsRepository->allByPruefungsId($pruefung->getId());
            foreach ($alleStudiPruefungen as $kohortenStudiPruefung) {
                $kohortenStudiPruefungsWertung = $this->studiPruefungsWertungRepository
                    ->byStudiPruefungsId($kohortenStudiPruefung->getId());
                if (!$kohortenStudiPruefungsWertung) {
                    continue;
                }
                $kohortenWertungen[] = $kohortenStudiPruefungsWertung->getGesamtErgebnis()->getPunktWertung()
                        ->getPunktzahl()->getValue();
            }

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
                "kohortenPunktzahlen" => $kohortenWertungen
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
                "durchschnittRichtigPunktzahl"    => $pruefungsWertung->getKohortenWertung()
                    ->getRichtigFalschWeissnichtWertung()->getPunktzahlRichtig()->getValue(),
                "durchschnittFalschPunktzahl"     => $pruefungsWertung->getKohortenWertung()
                    ->getRichtigFalschWeissnichtWertung()->getPunktzahlFalsch()->getValue(),
                "durchschnittWeissnichtPunktzahl" => $pruefungsWertung->getKohortenWertung()
                    ->getRichtigFalschWeissnichtWertung()->getPunktzahlWeissnicht()->getValue(),
                "maximalPunktzahl"                => $pruefungsWertung->getGesamtErgebnis()
                    ->getRichtigFalschWeissnichtWertung()->getGesamtPunktzahl()->getValue(),

            ];
        } else {
            throw new \Exception("Unbekanntes Format: " . $pruefung->getFormat()->getTitel());
        }
    }

    private function getStationsErgebnisDetailsAlsJsonArray(StudiPruefung $studiPruefung): array {
        [$pruefung, $itemWertungen] = $this->getPruefungUndWertungen($studiPruefung);
        if (!$pruefung->getFormat()->isStation()) {
            return [];
        }
    }

    private function getPTMErgebnisDetailsAlsJsonArray(StudiPruefung $studiPruefung): array {
        [$pruefung, $itemWertungen] = $this->getPruefungUndWertungen($studiPruefung);
        if (!$pruefung->getFormat()->isPTM()) {
            return [];
        }

        $itemsNachFach = $this->getItemsNachFach($itemWertungen);

        $fachAggregate = [];
        foreach ($itemsNachFach as $clusterId => $itemWertungen) {
            $fach = $this->clusterRepository->byId(ClusterId::fromInt($clusterId));

            [$alleMeineWertungen, $alleKohortenWertungen] = $this->getWertungen($itemWertungen);

            /** @var RichtigFalschWeissnichtWertung $meinDurchschnitt */
            $meinDurchschnitt = $itemWertungen[0]->getWertung()::getSummenWertung($alleMeineWertungen);
            /** @var RichtigFalschWeissnichtWertung $kohortenDurchschnitt */
            $kohortenDurchschnitt = $itemWertungen[0]->getWertung()::getDurchschnittsWertung($alleKohortenWertungen);

            $gruppe = $this->getFachGruppeByFach($fach);
            $fachAggregate[] = [
                "code"                   => $fach->getCode()->getValue(),
                "titel"                  => $fach->getTitel()->getValue(),
                "gruppe"                 => $gruppe,
                "ergebnisRichtigPunktzahl"      => $meinDurchschnitt->getPunktzahlRichtig()->getValue(),
                "ergebnisFalschPunktzahl"      => $meinDurchschnitt->getPunktzahlFalsch()->getValue(),
                "ergebnisWeissnichtPunktzahl"      => $meinDurchschnitt->getPunktzahlWeissnicht()->getValue(),

                "durchschnittRichtigPunktzahl" => $kohortenDurchschnitt->getPunktzahlRichtig()->getValue(),
                "durchschnittFalschPunktzahl" => $kohortenDurchschnitt->getPunktzahlFalsch()->getValue(),
                "durchschnittWeissnichtPunktzahl" => $kohortenDurchschnitt->getPunktzahlWeissnicht()->getValue(),

                "maximalPunktzahl"       => $meinDurchschnitt->getGesamtPunktzahl()->getValue(),
            ];
        }
        return [
            "faecher" => $fachAggregate,
        ];
    }

    private function getMCErgebnisDetailsAlsJsonArray(StudiPruefung $studiPruefung): array {
        [$pruefung, $itemWertungen] = $this->getPruefungUndWertungen($studiPruefung);
        if (!$pruefung->getFormat()->isMc()) {
            return [];
        }

        $itemsNachFach = $this->getItemsNachFach($itemWertungen);
        $itemsNachModul = $this->getItemsNachModul($itemWertungen);

        $fachAggregate = [];
        foreach ($itemsNachFach as $clusterId => $itemWertungen) {
            $fach = $this->clusterRepository->byId(ClusterId::fromInt($clusterId));
            [$alleMeineWertungen, $alleKohortenWertungen] = $this->getWertungen($itemWertungen);
            $meineSumme = $itemWertungen[0]->getWertung()::getSummenWertung($alleMeineWertungen);
            $kohortenSumme = $itemWertungen[0]->getWertung()::getSummenWertung($alleKohortenWertungen);
            $gruppe = $this->getFachGruppeByFach($fach);
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
            [$alleMeineWertungen, $alleKohortenWertungen] = $this->getWertungen($itemWertungen);
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

    private function getFachGruppeByFach(Cluster $fach): string {
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

        return $gruppe;
    }

    /**
     * @param $itemWertungen
     * @return array
     */
    private function getWertungen($itemWertungen): array {
        $alleMeineWertungen = [];
        $alleKohortenWertungen = [];
        foreach ($itemWertungen as $itemWertung) {
            $alleMeineWertungen[] = $itemWertung->getWertung();
            $alleKohortenWertungen[] = $itemWertung->getKohortenWertung();
        }

        return array($alleMeineWertungen, $alleKohortenWertungen);
    }

    /**
     * @param $itemWertungen
     * @return array
     */
    private function getItemsNachFach($itemWertungen): array {
        $itemsNachFach = [];
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

        return $itemsNachFach;
    }

    /**
     * @param $itemWertungen
     * @return array
     */
    private function getItemsNachModul($itemWertungen): array {
        $itemsNachModul = [];
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

        return $itemsNachModul;
    }

    /**
     * @param StudiPruefung $studiPruefung
     * @return array
     */
    private function getPruefungUndWertungen(StudiPruefung $studiPruefung): array {
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
        $itemWertungen = $this->itemWertungsRepository->allByStudiPruefungsId($studiPruefung->getId());

        return array($pruefung, $itemWertungen);
    }

}