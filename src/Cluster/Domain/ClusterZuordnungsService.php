<?php

namespace Cluster\Domain;

use Pruefung\Domain\PruefungsItemId;

interface ClusterZuordnungsService
{
    public function addZuordnung(ClusterZuordnung $clusterZuordnung);
    public function removeZuordnung(ClusterZuordnung $clusterZuordnung);

    /** @return ClusterId[] */
    public function alleClusterVonPruefungsItem(\Pruefung\Domain\PruefungsItemId $wertungsItemId) : array;

    /** @return \Pruefung\Domain\PruefungsItemId[] */
    public function allePruefungsItemsVonCluster(ClusterId $clusterId) : array;
}