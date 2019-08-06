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

    /** @var ?ClusterCode */
    private $code;

    /** @var ClusterId */
    private $parentId;

    public static function create(
        ClusterId $id,
        ClusterTypId $clusterTypId,
        ClusterTitel $titel,
        ?ClusterId $parentId = NULL,
        ?ClusterCode $clusterCode = NULL
    ): self {
        $object = new self();
        $object->id = $id;
        $object->titel = $titel;
        $object->clusterTypId = $clusterTypId;
        $object->parentId = $parentId;
        $object->code = $clusterCode;

        return $object;
    }

    public function getId(): ClusterId {
        return ClusterId::fromInt($this->id->getValue());
    }

    public function getClusterTypId(): ClusterTypId {
        return ClusterTypId::fromInt($this->clusterTypId);
    }

    public function getParentId(): ?ClusterId {
        return ClusterId::fromInt($this->parentId);
    }

    public function getTitel(): ClusterTitel {
        return $this->titel;
    }

    public function getCode(): ?ClusterCode {
        return $this->code;
    }


}