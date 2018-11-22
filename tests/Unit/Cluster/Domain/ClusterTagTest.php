<?php

namespace Tests\Unit\Cluster\Domain;


use Assert\InvalidArgumentException;
use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterBezeichnungEnthaeltHTMLException;
use Cluster\Domain\PruefungId;
use Cluster\Domain\ClusterTag;
use PHPUnit\Framework\TestCase;
use Cluster\Domain\Pruefungsformat;

class ClusterTagTest extends TestCase
{
    public function testCreate(){
        $clusterArt = Pruefungsformat::fromInt(Pruefungsformat::FACH_CLUSTER);
        $cluster = Cluster::fromValues($clusterArt, "Klinische Fächer");

        $clusterTagId = PruefungId::fromInt("12345");
        $clusterTag = ClusterTag::create($clusterTagId, $cluster);

        $this->assertEquals("12345", $clusterTag->getId());
        $this->assertEquals("Klinische Fächer", $clusterTag->getCluster()->getClusterBezeichnung());
    }





}