<?php

namespace DatenImport\Domain;

use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTyp;
use Cluster\Domain\ClusterZuordnungsService;
use Studi\Domain\StudiIntern;

class ChariteMCPruefungFachPersistenzService
{
    /** @var ClusterRepository */
    private $clusterRepository;

    /** @var ClusterZuordnungsService */
    private $clusterZuordnungsService;

    /** @var LernzielFachRepository */
    private $lernzielFachRepository;

    public function __construct(
        ClusterRepository $clusterRepository,
        ClusterZuordnungsService $clusterZuordnungsService,
        LernzielFachRepository $lernzielFachRepository
    ) {
        $this->clusterRepository = $clusterRepository;
        $this->clusterZuordnungsService = $clusterZuordnungsService;
        $this->lernzielFachRepository = $lernzielFachRepository;
    }

    /** @param StudiIntern[] $studiInternArray */
    public function persistiereFachZuordnung($mcPruefungsDaten) {
        $counter = 0;
        $lineCount = count($mcPruefungsDaten);
        $einProzent = round($lineCount / 100);
        $nichtGefunden = [];

        foreach ($mcPruefungsDaten as [$matrikelnummer, $punktzahl, $pruefungsItemId, $lernzielNummer]) {
            $counter++;
            if ($counter % $einProzent == 0) {
                echo "\n" . round($counter / $lineCount * 100) . "% fertig";
            }

            if ($lernzielNummer) {
                $fachClusterId = $this->lernzielFachRepository
                    ->getFachClusterIdByLernzielNummer(
                        LernzielNummer::fromInt($lernzielNummer)
                    );
                if (!$fachClusterId) {
                    if (!in_array("$lernzielNummer-$pruefungsItemId", $nichtGefunden)) {
                        echo "\nFehler: Lernziel-Nummer nicht gefunden zu Frage $pruefungsItemId: $lernzielNummer";
                        $nichtGefunden[] = "$lernzielNummer-$pruefungsItemId";
                    }
                    continue;
                }
                $fachCluster = $this->clusterRepository->byId($fachClusterId);

            }
            $this->clusterZuordnungsService->setzeZuordnungenFuerClusterTypId(
                $pruefungsItemId,
                ClusterTyp::getFachTyp(),
                [$fachCluster->getId()]
            );
        }
    }

}