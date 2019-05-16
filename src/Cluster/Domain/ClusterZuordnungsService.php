<?php

namespace Cluster\Domain;

use Common\Domain\FlushableRepository;
use Pruefung\Domain\PruefungsItemId;

interface ClusterZuordnungsService extends FlushableRepository
{
    public function addZuordnung(ClusterZuordnung $clusterZuordnung): void;

    public function removeZuordnung(ClusterZuordnung $clusterZuordnung): void;

    /** @return ClusterId[] */
    public function alleClusterVonPruefungsItem(PruefungsItemId $pruefungsItemId): array;

    /** @return PruefungsItemId[] */
    public function allePruefungsItemsVonCluster(ClusterId $clusterId): array;
}