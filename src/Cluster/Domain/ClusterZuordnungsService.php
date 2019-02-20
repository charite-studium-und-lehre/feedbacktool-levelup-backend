<?php

namespace Cluster\Domain;

use Common\Domain\FlushableRepository;

interface ClusterZuordnungsService extends FlushableRepository
{
    public function addZuordnung(ClusterZuordnung $clusterZuordnung): void;
    public function removeZuordnung(ClusterZuordnung $clusterZuordnung): void;

    /** @return ClusterId[] */
    public function alleClusterVonPruefungsItem(\Pruefung\Domain\PruefungsItemId $pruefungsItemId) : array;

    /** @return \Pruefung\Domain\PruefungsItemId[] */
    public function allePruefungsItemsVonCluster(ClusterId $clusterId) : array;
}