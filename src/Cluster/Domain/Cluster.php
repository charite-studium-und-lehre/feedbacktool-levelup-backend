<?php

namespace Cluster\Domain;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;

class Cluster implements DDDEntity
{
    use DefaultEntityComparison;

    /** @var ClusterId */
    private $id;

    /** @var ClusterTyp */
    private $clusterTyp;

    /** @var ClusterTitel */
    private $titel;

    /** @var ?ClusterCode */
    private $code;

    /** @var ClusterId */
    private $parentId;

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
        return ClusterId::fromInt($this->id->getValue());
    }

    public function getClusterTyp(): ClusterTyp {
        return $this->clusterTyp;
    }

    public function getParentId(): ?ClusterId {
        return ClusterId::fromInt($this->parentId);
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