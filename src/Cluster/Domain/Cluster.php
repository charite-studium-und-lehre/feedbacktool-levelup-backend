<?php

namespace Cluster\Domain;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;

class Cluster implements DDDEntity
{
    use DefaultEntityComparison;

    /** @var ClusterId */
    private $id;

    /** @var ClusterTypId */
    private $clusterTypId;

    /** @var ClusterTitel */
    private $titel;

    /** @var ClusterId */
    private $parentId;

    public static function create(
        ClusterId $id,
        ClusterTypId $clusterTypId,
        ClusterTitel $titel,
        ?ClusterId $parentId = NULL
    ): self {
        $object = new self();
        $object->id = $id;
        $object->titel = $titel;
        $object->clusterTypId = $clusterTypId;
        $object->parentId = $parentId;

        return $object;
    }

    public function getId(): ClusterId {
        return ClusterId::fromInt($this->id->getValue());
    }

    /** @return ClusterTypId */
    public function getClusterTypId(): ClusterTypId {
        return ClusterTypId::fromInt($this->clusterTypId);
    }

    /** @return mixed */
    public function getParentId() {
        return ClusterId::fromInt($this->parentId);
    }

    public function getTitel(): ClusterTitel {
        return $this->titel;
    }
}