<?php

namespace Tests\Unit\Cluster\Domain;


use Assert\InvalidArgumentException;
use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterBezeichnungEnthaeltHTMLException;
use PHPUnit\Framework\TestCase;
use Cluster\Domain\Pruefungsformat;

class ClusterTest extends TestCase
{
    public function testFromValues() {

        $art = Pruefungsformat::fromInt(Pruefungsformat::FACH_CLUSTER);
        $object = Cluster::fromValues($art, "Anatomie");

        $this->assertEquals($art, $object->getClusterArt());
        $this->assertEquals("Anatomie", $object->getClusterBezeichnung());
    }

    public function testFromIntFalschUngueltigerTag() {

        $this->expectException(ClusterBezeichnungEnthaeltHTMLException::class);

        $art = Pruefungsformat::fromInt(Pruefungsformat::FACH_CLUSTER);
        $clusterBezeichnung = "<Anatomie/>>";

        Cluster::fromValues($art, $clusterBezeichnung);
    }

    public function testFromIntFalschUngueltigerTagZuKurz() {

        $art = Pruefungsformat::fromInt(Pruefungsformat::LERNZIEL_CLUSTER);
        $clusterBezeichnung = "A";
        $this->expectExceptionMessage(Cluster::INVALID_ZU_KURZ);

        Cluster::fromValues($art, $clusterBezeichnung);
    }

    public function testFromIntFalschUngueltigerTagZuLang() {

        $art = Pruefungsformat::fromInt(Pruefungsformat::MODUL_CLUSTER);
        $clusterBezeichnung = "Diese Bezeichnung ist viieeeeeeeel zu lang und macht deshalb nicht wirklich Sinn für einen Tag!!!!";
        $this->expectExceptionMessage(Cluster::INVALID_ZU_LANG);

        Cluster::fromValues($art, $clusterBezeichnung);
    }





}