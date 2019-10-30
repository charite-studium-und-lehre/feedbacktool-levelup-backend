<?php

namespace StudiPruefung\Domain\Service;

use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTyp;
use Cluster\Domain\ClusterZuordnungsService;
use DatenImport\Domain\FachCodeKonstanten;
use Pruefung\Domain\FrageAntwort\AntwortRepository;
use Pruefung\Domain\FrageAntwort\FragenId;
use Pruefung\Domain\FrageAntwort\FragenRepository;
use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Domain\PruefungsRepository;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Wertung\Domain\ItemWertung;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\StudiPruefungsWertungRepository;

class StudiPruefungFragenAntwortenService
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

    /** …@var FragenRepository */
    private $fragenRepository;

    /** …@var AntwortRepository */
    private $antwortRepository;

    public function __construct(
        StudiPruefungsWertungRepository $studiPruefungsWertungRepository,
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsRepository $pruefungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        ItemWertungsRepository $itemWertungsRepository,
        ClusterZuordnungsService $clusterZuordnungsService,
        ClusterRepository $clusterRepository,
        FragenRepository $fragenRepository,
        AntwortRepository $antwortRepository
    ) {
        $this->studiPruefungsWertungRepository = $studiPruefungsWertungRepository;
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->pruefungsRepository = $pruefungsRepository;
        $this->pruefungsItemRepository = $pruefungsItemRepository;
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->clusterZuordnungsService = $clusterZuordnungsService;
        $this->clusterRepository = $clusterRepository;
        $this->fragenRepository = $fragenRepository;
        $this->antwortRepository = $antwortRepository;
    }

    public function getErgebnisAlsJsonArray(StudiPruefung $studiPruefung): array {
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());

        $einzelErgebnisse = $this->getMCErgebnisDetailsAlsJsonArray($studiPruefung);
        $pruefungsPeriode = $pruefung->getPruefungsPeriode();
        $returnArray = [
            "name"   => $pruefung->getName(),
            "typ"    => $pruefung->getFormat()->getCode(),
            "format" => $pruefung->getFormat()->getFormatAbstrakt(),
        ];
        $returnArray += ["studiPruefungsId" => $studiPruefung->getId()->getValue(),
                         "zeitsemester"     => $pruefungsPeriode->getZeitsemester()->getStandardStringLesbar(),
                         "periodeCode"      => $pruefungsPeriode->toInt(),
                         "periodeText"      => $pruefungsPeriode->getPeriodeBeschreibung(),
        ];
        $returnArray += $einzelErgebnisse;

        return $returnArray;
    }

    private function getMCErgebnisDetailsAlsJsonArray(StudiPruefung $studiPruefung): array {
        $itemWertungen = $this->getItemWertungen($studiPruefung);
        $fragen = [];
        foreach ($itemWertungen as $itemWertung) {
            $antwortGewaehlt = $itemWertung->getAntwortCode();
            $pruefungsItemId = $itemWertung->getPruefungsItemId();

            $fragenId = FragenId::fromString($pruefungsItemId->getValue());
            $frage = $this->fragenRepository->byId($fragenId);
            if (!$frage) {
                continue;
            }
            $antworten = $this->antwortRepository->allByFragenId($fragenId);
            $antwortenArray = [];
            foreach ($antworten as $antwort) {
                $antwortenArray[] = [
                    "text"        => $antwort->getAntwortCode()->getValue() . ") "
                        . $antwort->getAntwortText()->getValue(),
                    "richtig"     => $antwort->istRichtig() ? true : false,
                    "ausgewaehlt" => $antwort->getAntwortCode()->equals($antwortGewaehlt) ? true : false,
                ];
            }

            $fachClusters = $this->clusterZuordnungsService
                ->getVorhandeneClusterIdsNachTyp($pruefungsItemId,
                                                 ClusterTyp::getFachTyp());
            if ($fachClusters) {
                $fachClusterId = $fachClusters[0];
                $fachCluster = $this->clusterRepository->byId($fachClusterId);
                $fachGruppe = FachCodeKonstanten::getFachGruppeByFach($fachCluster->getCode()->getValue());
            }
            $modulClusters = $this->clusterZuordnungsService
                ->getVorhandeneClusterIdsNachTyp($pruefungsItemId,
                                                 ClusterTyp::getModulTyp());
            if ($modulClusters) {
                $modulClusterId = $modulClusters[0];
                $modulCluster = $this->clusterRepository->byId($modulClusterId);
            }

            $fragen[] = [
                "id"                  => $fragenId->getValue(),
                "durchschnittRichtig" => $itemWertung->getKohortenWertung()
                    ? $itemWertung->getKohortenWertung()->getPunktzahl()->getValue()
                    : NULL,
                "text"                => $frage->getFragenText()->getValue(),
                "antworten"           => $antwortenArray,
                "fach"                => [
                    "code"   => isset($fachCluster) ? $fachCluster->getCode()->getValue() : NULL,
                    "titel"  => isset($fachCluster) ? $fachCluster->getTitel()->getValue() : NULL,
                    "gruppe" => isset($fachGruppe) ? $fachGruppe : NULL,
                ],
                "modul"               => [
                    "code"  => isset($modulCluster) ? $modulCluster->getCode()->getValue() : NULL,
                    "titel" => isset($modulCluster) ? $modulCluster->getTitel()->getValue() : NULL,
                ],

            ];
        }

        return ["fragen" => $fragen];
    }

    private function getWertungen($itemWertungen): array {
        $alleMeineWertungen = [];
        $alleKohortenWertungen = [];
        foreach ($itemWertungen as $itemWertung) {
            $alleMeineWertungen[] = $itemWertung->getWertung();
            $alleKohortenWertungen[] = $itemWertung->getKohortenWertung();
        }

        return [$alleMeineWertungen, $alleKohortenWertungen];
    }

    /** @return ItemWertung[] */
    private function getItemsNachClusterTyp($itemWertungen, ClusterTyp $clusterTyp): array {
        $itemsNachFach = [];
        foreach ($itemWertungen as $itemWertung) {
            $clusterIds = $this->clusterZuordnungsService->getVorhandeneClusterIdsNachTyp(
                $itemWertung->getPruefungsItemId(),
                $clusterTyp
            );
            if ($clusterIds) {
                $fachClusterId = $clusterIds[0];
                $itemsNachFach[$fachClusterId->getValue()][] = $itemWertung;
            }
        }

        return $itemsNachFach;
    }

    /** @return ItemWertung[] */
    private function getItemWertungen(StudiPruefung $studiPruefung): array {
        $itemWertungen = $this->itemWertungsRepository->allByStudiPruefungsId($studiPruefung->getId());

        return $itemWertungen;
    }

}