<?php

namespace Tests\Unit\Cluster\Domain;


use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterTag;
use PHPUnit\Framework\TestCase;
use Cluster\Domain\ClusterArt;

class ClusterTagTest extends TestCase
{
    public function testCreate(){
        $clusterArt = ClusterArt::fromInt(ClusterArt::FACH_CLUSTER);
        $cluster = Cluster::fromValues($clusterArt, "Klinische Fächer");

        $clusterTagId = ClusterId::fromInt("12345");
        $clusterTag = ClusterTag::create($clusterTagId, $cluster);

        $this->assertEquals("12345", $clusterTag->getId());
        $this->assertEquals("Klinische Fächer", $clusterTag->getCluster()->getClusterBezeichnung());
    }





}