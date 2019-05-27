<?php

namespace Cluster\Domain;

use Common\Domain\FlushableRepository;
use Pruefung\Domain\PruefungsItemId;

interface ClusterZuordnungsRepository extends FlushableRepository
{
    /** @return ClusterZuordnung[] */
    public function all(): array;

    public function addZuordnung(ClusterZuordnung $clusterZuordnung): void;

    /** @return ClusterId[] */
    public function alleClusterIdsVonPruefungsItem(PruefungsItemId $pruefungsItemId): array;

    /** @return PruefungsItemId[] */
    public function allePruefungsItemsVonCluster(ClusterId $clusterId): array;

    public function delete(ClusterZuordnung $clusterZuordnung): void;
}