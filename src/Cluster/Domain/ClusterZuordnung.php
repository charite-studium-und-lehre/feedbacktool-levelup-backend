<?php

namespace Cluster\Domain;

use Common\Domain\DefaultValueObjectComparison;
use Pruefung\Domain\PruefungsItemId;

class ClusterZuordnung
{
    /** @var ClusterId */
    private $clusterId;

    /** @var PruefungsItemId */
    private $pruefungsItemId;

    use DefaultValueObjectComparison;

    public static function byIds(ClusterId $clusterId, PruefungsItemId $pruefungsItemId) {
        $object = new self();
        $object->clusterId = $clusterId;
        $object->pruefungsItemId = $pruefungsItemId;

        return $object;
    }

    public function getClusterId(): ClusterId {
        return $this->clusterId;
    }

    public function getPruefungsItemId(): PruefungsItemId {
        return $this->pruefungsItemId;
    }
}