<?php

namespace Tests\Unit\Cluster\Domain;


use Cluster\Domain\ClusterTypTitel;
use Cluster\Domain\ClusterId;
use Cluster\Domain\Cluster;
use PHPUnit\Framework\TestCase;
use Cluster\Domain\ClusterTyp;

class ClusterTagTest extends TestCase
{
    public function testCreate(){
        $clusterArt = ClusterTyp::fromInt(ClusterTyp::FACH_CLUSTER);
        $cluster = ClusterTypTitel::fromValues($clusterArt, "Klinische Fächer");

        $clusterTagId = ClusterId::fromInt("12345");
        $clusterTag = Cluster::create($clusterTagId, $cluster);

        $this->assertEquals("12345", $clusterTag->getId());
        $this->assertEquals("Klinische Fächer", $clusterTag->getCluster()->getClusterBezeichnung());
    }





}