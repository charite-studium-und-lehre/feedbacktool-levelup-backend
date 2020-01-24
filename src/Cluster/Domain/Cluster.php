<?php

namespace Cluster\Domain;

use Common\Domain\AggregateId;
use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;

class Cluster implements DDDEntity
{
    use DefaultEntityComparison;

    private ClusterId $id;

    private ClusterTyp $clusterTyp;

    private ClusterTitel $titel;

    private ?ClusterCode $code;

    private ?AggregateId $parentId;

    public static function create(
        ClusterId $id,
        ClusterTyp $clusterTyp,
        ClusterTitel $titel,
        ?ClusterId $parentId = NULL,
        ?ClusterCode $clusterCode = NULL
    ): self {
        $object = new self();
        $object->id = $id;
        $object->titel = $titel;
        $object->clusterTyp = $clusterTyp;
        $object->parentId = $parentId;
        $object->code = $clusterCode;

        return $object;
    }

    public function getId(): ClusterId {
        return $this->id;
    }

    public function getClusterTyp(): ClusterTyp {
        return $this->clusterTyp;
    }

    public function getParentId(): ?ClusterId {
        return $this->parentId;
    }

    public function getTitel(): ClusterTitel {
        return $this->titel;
    }

    public function setTitel(ClusterTitel $titel): void {
        $this->titel = $titel;
    }

    public function getCode(): ?ClusterCode {
        return $this->code;
    }

}