<?php

namespace Cluster\Domain;

use Common\Domain\DefaultValueObjectComparison;
use Pruefung\Domain\PruefungsItemId;

class ClusterZuordnung
{
    /** @var ClusterId */
    private $clusterId;

    /** @var \Pruefung\Domain\PruefungsItemId */
    private $wertungsItemId;

    use DefaultValueObjectComparison;

    public function getClusterId(): ClusterId {
        return $this->clusterId;
    }

    public function getWertungsItemId(): PruefungsItemId {
        return $this->wertungsItemId;
    }
}