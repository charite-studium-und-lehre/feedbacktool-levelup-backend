<?php

namespace Cluster\Domain;

use Common\Domain\DefaultValueObjectComparison;
use Pruefung\Domain\PruefungsItemId;

class ClusterZuordnung
{
    use DefaultValueObjectComparison;

    private ClusterId $clusterId;

    private PruefungsItemId $pruefungsItemId;

    public static function byIds(ClusterId $clusterId, PruefungsItemId $pruefungsItemId): ClusterZuordnung {
        $object = new self();
        $object->clusterId = $clusterId;
        $object->pruefungsItemId = $pruefungsItemId;

        return $object;
    }

    public function getClusterId(): ClusterId {
        return $this->clusterId;
    }

    public function getPruefungsItemId(): PruefungsItemId {
        return PruefungsItemId::fromString($this->pruefungsItemId);
    }
}