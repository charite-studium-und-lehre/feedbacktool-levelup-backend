<?php

namespace DatenImport\Domain;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTitel;
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

        foreach ($mcPruefungsDaten as [$matrikelnummer, $punktzahl, $pruefungsItemId, $lernzielNummer]) {

            $zuzuordnen = [];

            if ($lernzielNummer) {
                $fachClusterId = $this->lernzielFachRepository
                    ->getFachClusterIdByLernzielNummer(
                        LernzielNummer::fromInt($lernzielNummer)
                    );
                if ($fachClusterId) {
                    $fachCluster = $this->clusterRepository->byId($fachClusterId);
                    $zuzuordnen = [$fachCluster->getId()];
                }
            }
            $this->clusterZuordnungsService->setzeZuordnungenFuerClusterTypId(
                $pruefungsItemId,
                ClusterTyp::getFachTyp(),
                $zuzuordnen
            );
        }

    }


}