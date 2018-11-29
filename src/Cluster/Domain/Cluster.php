<?php

namespace Cluster\Domain;

use Common\Domain\DefaultEntityComparison;

class ClusterTag
{
    use DefaultEntityComparison;

    /** @var ClusterTagId */
    private $id;

    /** @var Cluster */
    private $cluster;

    /** @var String */
    private $kommentar;


    public static function create(
        ClusterId $id,
        Cluster $cluster,
        String $kommentar = NULL
    ): self {

        $object = new self();
        $object->id = $id;
        $object->cluster = $cluster;
        $object->kommentar = $kommentar;


        return $object;
    }

    public function getId(): ClusterId {
        return ClusterId::fromInt($this->id->getValue());
    }

    public function getCluster(): Cluster {
        return $this->cluster;
    }

    public function getKommentar(){
        return $this->kommentar;
    }

    public function setKommentar(String $kommentar) {
        $this->kommentar = $kommentar;
    }

}