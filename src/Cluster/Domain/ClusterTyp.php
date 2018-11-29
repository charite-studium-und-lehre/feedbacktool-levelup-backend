<?php

namespace Cluster\Domain;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

class ClusterArt
{
    use DefaultValueObjectComparison;

    /** @var ClusterArtId */
    private $id;


    private $titel;


    const INVALID_CLUSTERART = "Keine gültige Clusterart: ";


    public static function fromInt(): self {


        $object = new self();
        $object->clusterart = $clusterart;

        return $object;
    }

    public function getClusterArt() {
        return $this->clusterart;

    }
}