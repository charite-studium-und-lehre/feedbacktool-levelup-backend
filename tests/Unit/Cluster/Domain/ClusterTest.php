<?php

namespace Tests\Unit\Cluster\Domain;


use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Cluster\Domain\ClusterArt;

class ClusterArtTest extends TestCase
{

    public function testFromInt() {
        $clusterArt = ClusterArt::FACH_CLUSTER;
        $object = ClusterArt::fromInt($clusterArt);

        $this->assertEquals($clusterArt, $object->getClusterArt());
    }

    public function testFromIntFalsch() {
        $clusterArt = ClusterArt::MODUL_CLUSTER;
        $object = ClusterArt::fromInt(ClusterArt::LERNZIEL_CLUSTER);

        $this->assertNotEquals($clusterArt, $object->getClusterArt());
    }

    public function testFromIntFalschClusterUngueltig() {
        $clusterArt = 123;
        $this->expectExceptionMessage(ClusterArt::INVALID_CLUSTERART);
        ClusterArt::fromInt($clusterArt);

    }

}