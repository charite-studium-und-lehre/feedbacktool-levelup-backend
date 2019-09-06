<?php

namespace Cluster\Domain;

use Pruefung\Domain\PruefungsItemId;

class ClusterZuordnungsService
{
    /** @var ClusterZuordnungsRepository */
    private $clusterZuordnungsRepository;

    /** @var ClusterRepository */
    private $clusterRepository;

    public function __construct(
        ClusterZuordnungsRepository $clusterZuordnungsRepository,
        ClusterRepository $clusterRepository
    ) {
        $this->clusterZuordnungsRepository = $clusterZuordnungsRepository;
        $this->clusterRepository = $clusterRepository;
    }

    /**
     * Erstellt und löscht Zuordnungen eines Clustertyps, so dass alle zuordnungen der geg. Liste entsprechen
     *
     * @param ClusterId[] $clusterIdsZuzuordnen
     */
    public function setzeZuordnungenFuerClusterTypId(
        PruefungsItemId $pruefungsItemId,
        ClusterTyp $clusterTypId,
        array $clusterIdsZuzuordnen
    ) {

        $aktuelleClusterIds = $this->getVorhandeneClusterIdsNachTyp($pruefungsItemId, $clusterTypId,);

        $clusterIdsNeuZuzuordnen =
            $this->findeClusterIdsNeuZuzuordnen(
                $aktuelleClusterIds,
                $clusterIdsZuzuordnen
            );
        foreach ($clusterIdsNeuZuzuordnen as $clusterIdNeuZuzuordnen) {
            echo "+";
            $this->clusterZuordnungsRepository->addZuordnung(
                ClusterZuordnung::byIds(
                    $clusterIdNeuZuzuordnen,
                    $pruefungsItemId
                )
            );
        }

        $clusterIdsZuLoeschen = $this->getClusterIdsZuLoeschen(
            $aktuelleClusterIds,
            $clusterIdsZuzuordnen
        );
        foreach ($clusterIdsZuLoeschen as $clusterIdZuLoeschen) {
            echo "-";
            $this->clusterZuordnungsRepository->delete(
                ClusterZuordnung::byIds(
                    $clusterIdNeuZuzuordnen,
                    $pruefungsItemId
                )
            );
        }

        $this->clusterZuordnungsRepository->flush();

    }

    /**
     * @param ClusterTyp $clusterTypId
     * @param $vorhandeneClusterIds
     * @return ClusterId[]
     */
    public function getVorhandeneClusterIdsNachTyp(
        PruefungsItemId $pruefungsItemId,
        ClusterTyp $clusterTypId
    ): array {
        $vorhandeneClusterIds = $this->clusterZuordnungsRepository->alleClusterIdsVonPruefungsItem($pruefungsItemId);
        $gefilterteClusterIds = [];
        foreach ($vorhandeneClusterIds as $vorhandenerClusterId) {
            $cluster = $this->clusterRepository->byId($vorhandenerClusterId);
            if ($cluster->getClusterTyp()->equals($clusterTypId)) {
                $gefilterteClusterIds[] = $vorhandenerClusterId;
            }
        }

        return $gefilterteClusterIds;
    }

    /**
     * @param ClusterId[] $aktuelleClusterIds
     * @param ClusterId[] $clusterIdsZuzuordnen
     * @return ClusterId[]
     */
    private function findeClusterIdsNeuZuzuordnen(array $aktuelleClusterIds, array $clusterIdsZuzuordnen): array {
        $clusterIdsNeuZuzuordnen = [];
        foreach ($clusterIdsZuzuordnen as $clusterIdZuzuordnen) {
            $gefunden = FALSE;
            foreach ($aktuelleClusterIds as $aktuelleClusterId) {
                if ($aktuelleClusterId->equals($clusterIdZuzuordnen)) {
                    $gefunden = TRUE;
                }
            }
            if (!$gefunden) {
                $clusterIdsNeuZuzuordnen[] = $clusterIdZuzuordnen;
            }
        }

        return $clusterIdsNeuZuzuordnen;
    }

    /**
     * @param ClusterId[] $aktuelleClusterIds
     * @param ClusterId[] $clusterIdsZuzuordnen
     * @return ClusterId[]
     */
    private function getClusterIdsZuLoeschen(array $aktuelleClusterIds, array $clusterIdsZuzuordnen): array {
        $clusterIdsZuLoeschen = [];
        foreach ($aktuelleClusterIds as $clusterIdZuLoeschen) {
            $gefunden = FALSE;
            foreach ($clusterIdsZuzuordnen as $clusterIdZuzuordnen) {
                if ($clusterIdZuLoeschen->equals($clusterIdZuzuordnen)) {
                    $gefunden = TRUE;
                }
            }
            if (!$gefunden) {
                $clusterIdsZuLoeschen[] = $clusterIdZuLoeschen;
            }
        }

        return $clusterIdsZuLoeschen;
    }

}