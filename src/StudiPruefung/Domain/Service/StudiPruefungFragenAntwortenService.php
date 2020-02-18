<?php

namespace StudiPruefung\Domain\Service;

use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTyp;
use Cluster\Domain\ClusterZuordnungsService;
use Pruefung\Domain\FachCodeKonstanten;
use Pruefung\Domain\FrageAntwort\AntwortRepository;
use Pruefung\Domain\FrageAntwort\FragenId;
use Pruefung\Domain\FrageAntwort\FragenRepository;
use Pruefung\Domain\PruefungsRepository;
use StudiPruefung\Domain\StudiPruefung;
use Wertung\Domain\ItemWertung;
use Wertung\Domain\ItemWertungsRepository;

class StudiPruefungFragenAntwortenService
{
    private PruefungsRepository $pruefungsRepository;

    private ItemWertungsRepository $itemWertungsRepository;

    private ClusterZuordnungsService $clusterZuordnungsService;

    private ClusterRepository $clusterRepository;

    /** …@var FragenRepository */
    private FragenRepository $fragenRepository;

    /** …@var AntwortRepository */
    private AntwortRepository $antwortRepository;

    public function __construct(
        PruefungsRepository $pruefungsRepository,
        ItemWertungsRepository $itemWertungsRepository,
        ClusterZuordnungsService $clusterZuordnungsService,
        ClusterRepository $clusterRepository,
        FragenRepository $fragenRepository,
        AntwortRepository $antwortRepository
    ) {
        $this->pruefungsRepository = $pruefungsRepository;
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->clusterZuordnungsService = $clusterZuordnungsService;
        $this->clusterRepository = $clusterRepository;
        $this->fragenRepository = $fragenRepository;
        $this->antwortRepository = $antwortRepository;
    }

    /** @return array<string, array<int, array<string, mixed>>|int|string> */
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

    /** @return array<string, array<int, array<string, mixed>>> */
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
                    "richtig"     => $antwort->istRichtig(),
                    "ausgewaehlt" => $antwortGewaehlt && $antwort->getAntwortCode()->equals($antwortGewaehlt),
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

    /** @return ItemWertung[] */
    private function getItemWertungen(StudiPruefung $studiPruefung): array {
        return $this->itemWertungsRepository->allByStudiPruefungsId($studiPruefung->getId());
    }
}