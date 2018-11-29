<?php

namespace Tests\Unit\Cluster\Domain;


use Assert\InvalidArgumentException;
use Cluster\Domain\ClusterTypTitel;
use Cluster\Domain\ClusterBezeichnungEnthaeltHTMLException;
use PHPUnit\Framework\TestCase;
use Cluster\Domain\ClusterTyp;

class ClusterTest extends TestCase
{
    public function testFromValues() {

        $art = ClusterTyp::fromInt(ClusterTyp::FACH_CLUSTER);
        $object = ClusterTypTitel::fromValues($art, "Anatomie");

        $this->assertEquals($art, $object->getClusterArt());
        $this->assertEquals("Anatomie", $object->getClusterBezeichnung());
    }

    public function testFromIntFalschUngueltigerTag() {

        $this->expectException(ClusterBezeichnungEnthaeltHTMLException::class);

        $art = ClusterTyp::fromInt(ClusterTyp::FACH_CLUSTER);
        $clusterBezeichnung = "<Anatomie/>>";

        ClusterTypTitel::fromValues($art, $clusterBezeichnung);

    }

    public function testFromIntFalschUngueltigerTagZuKurz() {

        $art = ClusterTyp::fromInt(ClusterTyp::LERNZIEL_CLUSTER);
        $clusterBezeichnung = "A";
        $this->expectExceptionMessage(ClusterTypTitel::INVALID_ZU_KURZ);

        ClusterTypTitel::fromValues($art, $clusterBezeichnung);

    }

    public function testFromIntFalschUngueltigerTagZuLang() {

        $art = ClusterTyp::fromInt(ClusterTyp::MODUL_CLUSTER);
        $clusterBezeichnung = "Diese Bezeichnung ist viieeeeeeeel zu lang und macht deshalb nicht wirklich Sinn für einen Tag!!!!";
        $this->expectExceptionMessage(ClusterTypTitel::INVALID_ZU_LANG);

        ClusterTypTitel::fromValues($art, $clusterBezeichnung);

    }





}