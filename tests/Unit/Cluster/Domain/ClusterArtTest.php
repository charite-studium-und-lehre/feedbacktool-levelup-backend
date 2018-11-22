<?php

namespace Tests\Unit\Cluster\Domain;


use Cluster\Domain\Pruefungsformat;
use PHPUnit\Framework\TestCase;

class ClusterArtTest extends TestCase
{

    public function testFromInt() {
        $art = Pruefungsformat::FACH_CLUSTER;
        $object = Pruefungsformat::fromInt($art);

        $this->assertEquals($art, $object->getClusterArt());
    }

    public function testFromIntFalsch() {
        $clusterArt = Pruefungsformat::MODUL_CLUSTER;
        $object = Pruefungsformat::fromInt(Pruefungsformat::LERNZIEL_CLUSTER);

        $this->assertNotEquals($clusterArt, $object->getClusterArt());
    }

    public function testFromIntFalschClusterUngueltig() {
        $clusterArt = 123;
        $this->expectExceptionMessage(Pruefungsformat::INVALID_CLUSTERART);
        Pruefungsformat::fromInt($clusterArt);

    }
}