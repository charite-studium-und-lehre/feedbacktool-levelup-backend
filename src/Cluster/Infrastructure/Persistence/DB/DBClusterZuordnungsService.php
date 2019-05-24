<?php

namespace Cluster\Infrastructure\Persistence\DB;

use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterZuordnung;
use Cluster\Domain\ClusterZuordnungsService;
use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Pruefung\Domain\PruefungsItemId;

final class DBClusterZuordnungsService implements ClusterZuordnungsService
{
    use DDDDoctrineRepoTrait;

    public function addZuordnung(ClusterZuordnung $clusterZuordnung): void {
        if (!$this->sucheAktuelleZuordnung($clusterZuordnung)) {
            $this->entityManager->persist($clusterZuordnung);
        }
    }

    public function removeZuordnung(ClusterZuordnung $clusterZuordnung): void {
        $gefundeneZuordnung = $this->sucheAktuelleZuordnung($clusterZuordnung);
        if ($gefundeneZuordnung) {
            $this->entityManager->remove($gefundeneZuordnung);
        }
    }

    /** @return ClusterId[] */
    public function alleClusterVonPruefungsItem(PruefungsItemId $pruefungsItemId): array {
        return $this->doctrineRepo
            ->findBy(
                ["pruefungsItemId" => $pruefungsItemId]
            );
    }

    /** @return \Pruefung\Domain\PruefungsItemId[] */
    public function allePruefungsItemsVonCluster(ClusterId $clusterId): array {
        return $this->doctrineRepo
            ->findBy(
                ["clusterId" => $clusterId]
            );
    }

    public function delete(ClusterZuordnung $clusterZuordnung): void {
        $this->abstractDelete($clusterZuordnung);
    }

    private function sucheAktuelleZuordnung(ClusterZuordnung $clusterZuordnung): ?ClusterZuordnung {
        return $this->doctrineRepo->findOneBy(
            [
                "pruefungsItemId" => $clusterZuordnung->getPruefungsItemId(),
                "clusterId"       => $clusterZuordnung->getClusterId()]
        );
    }

}