<?php

namespace Cluster\Domain;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;

class ClusterTyp implements DDDEntity
{
    use DefaultEntityComparison;

    /** @var ClusterTypId */
    private $id;

    /** @var ClusterTypTitel */
    private $titel;

    /** @var ClusterTypId */
    private $parentId;

    public static function create(ClusterTypId $id, ClusterTypTitel $titel, ?ClusterTypId $parentId = NULL): self {

        $object = new self();
        $object->id = $id;
        $object->titel = $titel;
        $object->parentId = $parentId;

        return $object;
    }

    public function getTitel(): ClusterTypTitel {
        return $this->titel;
    }

    public function getId(): ClusterTypId {
        return $this->id;
    }

    public function getParentId(): ClusterTypId {
        return $this->parentId;
    }
}