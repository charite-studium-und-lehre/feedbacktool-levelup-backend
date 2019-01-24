<?php

namespace Tests\Unit\Cluster\Domain;

use Cluster\Domain\ClusterBezeichnungEnthaeltHTMLException;
use Cluster\Domain\ClusterTitel;
use PHPUnit\Framework\TestCase;

class ClusterTypTitelTest extends TestCase
{
    public function testFromValues() {

        $object = ClusterTitel::fromString("Anatomie");

        $this->assertEquals($object->getValue(), "Anatomie");
    }

    public function testFromIntFalschZuKurz() {
        $this->expectExceptionMessage(ClusterTitel::INVALID_ZU_KURZ);
        ClusterTitel::fromString("A");
    }

    public function testFromIntFalschZuLang() {
        $this->expectExceptionMessage(ClusterTitel::INVALID_ZU_LANG);
        ClusterTitel::fromString("Biologie für Mediziner und Anatomie
    Histologie einschließlich Ultrastruktur von Zellen und Geweben. Histochemie. Makroskopische und Mikroskopische Anatomie der Kreislauforgane, der Eingeweide, des Nervensystems und der Sinnesorgane, des Bewegungsapparates, der Haut, des endokrinen Systems und des Immunsystems. Zusammenwirken der Systeme. Altersabhängige Besonderheiten. Topographische Anatomie. Grundzüge der Frühentwicklung des Menschen und der Organentwicklung.
    Allgemeine Zytologie. Grundlagen der Humangenetik, Genetik. Grundlagen der Mikrobiologie. Grundzüge der Ökologie.");
    }

}