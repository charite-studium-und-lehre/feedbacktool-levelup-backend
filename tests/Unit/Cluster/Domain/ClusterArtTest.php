<?php

namespace Tests\Unit\Cluster\Domain;


use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ClusterArt extends TestCase
{
    public function testFromInt() {
        $clusterArt = \Cluster\Domain\ClusterArt::FACH_CLUSTER;
        $object = \Cluster\Domain\ClusterArt::fromInt($clusterArt);

        $this->assertEquals($clusterArt, $object->getClusterArt());
    }

//    public function testFromInt_FalschZuKlein() {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage(Matrikelnummer::INVALID_STELLEN);
//        Matrikelnummer::fromInt(12345);
//    }
//
//    public function testFromInt_FalschZuGross() {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage(Matrikelnummer::INVALID_STELLEN);
//        Matrikelnummer::fromInt(1234567);
//    }
//
//    public function testFromInt_FalschString() {
//        $this->expectException(InvalidArgumentException::class);
//        Matrikelnummer::fromInt("123456ab");
//    }
//
//    public function testFromInt_FalschString2() {
//        $this->expectException(InvalidArgumentException::class);
//        Matrikelnummer::fromInt("123456.2");
//    }
}