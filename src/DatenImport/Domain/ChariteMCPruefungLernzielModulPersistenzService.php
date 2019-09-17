<?php

namespace DatenImport\Domain;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTitel;
use Cluster\Domain\ClusterTyp;
use Cluster\Domain\ClusterZuordnungsService;
use Studi\Domain\StudiIntern;

class ChariteMCPruefungLernzielModulPersistenzService
{
    /** @var ClusterRepository */
    private $clusterRepository;

    /** @var ClusterZuordnungsService */
    private $clusterZuordnungsService;

    public function __construct(
        ClusterRepository $clusterRepository,
        ClusterZuordnungsService $clusterZuordnungsService
    ) {
        $this->clusterRepository = $clusterRepository;
        $this->clusterZuordnungsService = $clusterZuordnungsService;
    }

    /** @param StudiIntern[] $studiInternArray */
    public function persistiereMcModulZuordnung($mcPruefungsDaten, $lzModulDaten) {
        $counter = 0;
        $lineCount = count($mcPruefungsDaten);
        $einProzent = round($lineCount / 100);
        $nichtGefunden = [];

        foreach ($mcPruefungsDaten as
        [$matrikelnummer,
            $punktzahl,
            $pruefungsId,
            $pruefungsItemId,
            $fragenNr,
            $lzNummer,
            $gesamtErreichtePunktzahl,
            $fragenAnzahl,
            $bestehensGrenze,
            $schwierigkeit]
        ) {
            $counter++;
            if ($counter % $einProzent == 0) {
                echo "\n" . round($counter / $lineCount * 100) . "% fertig";
            }
            if (!$lzNummer) {
                continue;
            }

            $fragenModul = isset($lzModulDaten[$lzNummer]) ? $lzModulDaten[$lzNummer] : NULL;
            if (!$fragenModul) {
                if (!in_array("$lzNummer-$pruefungsItemId", $nichtGefunden)) {
                    echo "\nFehler: Lernziel-Nummer nicht gefunden zu Frage $pruefungsItemId: $lzNummer";
                    $nichtGefunden[] = "$lzNummer-$pruefungsItemId";
                }
                continue;
            }

            $cluster = $this->clusterRepository->byClusterTypUndTitel(
                ClusterTyp::getModulTyp(),
                $fragenModul
            );
            if (!$cluster) {
                $clusterId = $this->clusterHinzufuegen($fragenModul);
            } else {
                $clusterId = $cluster->getId();
            }

            $this->clusterZuordnungsService->setzeZuordnungenFuerClusterTypId(
                $pruefungsItemId,
                ClusterTyp::getModulTyp(),
                [$clusterId]
            );
        }

    }

    private function clusterHinzufuegen(ClusterTitel $fragenModul): ClusterId {
        $clusterId = $this->clusterRepository->nextIdentity();
        $this->clusterRepository->add(
            Cluster::create(
                $clusterId,
                ClusterTyp::getModulTyp(),
                $fragenModul
            )
        );
        $this->clusterRepository->flush();

        return $clusterId;
    }

}