<?php

namespace Cluster\Infrastructure\Persistence\DB;

use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterZuordnung;
use Cluster\Domain\ClusterZuordnungsRepository;
use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Pruefung\Domain\PruefungsItemId;

final class DBClusterZuordnungsRepository implements ClusterZuordnungsRepository
{
    use DDDDoctrineRepoTrait;

    public function addZuordnung(ClusterZuordnung $clusterZuordnung): void {
        if (!$this->sucheAktuelleZuordnung($clusterZuordnung)) {
            $this->entityManager->persist($clusterZuordnung);
        }
    }

    public function delete(ClusterZuordnung $clusterZuordnung): void {
        $gefundeneZuordnung = $this->sucheAktuelleZuordnung($clusterZuordnung);
        if ($gefundeneZuordnung) {
            $this->abstractDelete($gefundeneZuordnung);
        }
    }

    /** @return ClusterId[] */
    public function alleClusterIdsVonPruefungsItem(PruefungsItemId $pruefungsItemId): array {
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

    private function sucheAktuelleZuordnung(ClusterZuordnung $clusterZuordnung): ?ClusterZuordnung {
        return $this->doctrineRepo->findOneBy(
            [
                "pruefungsItemId" => $clusterZuordnung->getPruefungsItemId(),
                "clusterId"       => $clusterZuordnung->getClusterId()]
        );
    }

}