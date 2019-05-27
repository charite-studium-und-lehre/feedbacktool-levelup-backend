<?php

namespace DatenImport\Domain;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTitel;
use Cluster\Domain\ClusterTypId;
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

        foreach ($mcPruefungsDaten as [$matrikelnummer, $punktzahl, $pruefungsItemId, $fragenFach, $lernzielNummer]) {

            $zuzuordnen = [];
            if ($lernzielNummer) {
                $fragenModul = $lzModulDaten[$lernzielNummer->getValue()];
                $cluster = $this->clusterRepository->byClusterTypIdUndTitel(
                    ClusterTypId::fromInt(ClusterTypId::TYP_ID_MODUL),
                    $fragenModul
                );
                if (!$cluster) {
                    $clusterId = $this->clusterHinzufuegen($fragenModul);
                } else {
                    $clusterId = $cluster->getId();
                }
                $zuzuordnen = [$clusterId];
            }
            $this->clusterZuordnungsService->setzeZuordnungenFuerClusterTypId(
                $pruefungsItemId,
                ClusterTypId::fromInt(ClusterTypId::TYP_ID_MODUL),
                $zuzuordnen
            );
        }

    }

    private function clusterHinzufuegen(ClusterTitel $fragenModul): ClusterId {
        $clusterId = $this->clusterRepository->nextIdentity();
        $this->clusterRepository->add(
            Cluster::create(
                $clusterId,
                ClusterTypId::fromInt(ClusterTypId::TYP_ID_MODUL),
                $fragenModul
            )
        );
        $this->clusterRepository->flush();

        return $clusterId;
    }

}