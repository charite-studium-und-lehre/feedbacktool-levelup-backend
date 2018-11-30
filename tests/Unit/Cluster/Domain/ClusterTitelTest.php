<?php

namespace Tests\Unit\Cluster\Domain;

use Cluster\Domain\ClusterBezeichnungEnthaeltHTMLException;
use Cluster\Domain\ClusterTitel;
use Cluster\Domain\ClusterTypTitel;
use PHPUnit\Framework\TestCase;

class ClusterTypTitelTest extends TestCase
{
    public function testFromValues() {

        $object = ClusterTypTitel::fromString("Fach");

        $this->assertEquals($object->getValue(), "Fach");
    }

    public function testFromIntFalschZuKurz() {
        $this->expectExceptionMessage(ClusterTitel::INVALID_ZU_KURZ);
        ClusterTitel::fromString("F");
    }

    public function testFromIntFalschZuLang() {
        $this->expectExceptionMessage(ClusterTitel::INVALID_ZU_LANG);
        ClusterTitel::fromString("Ein Fach, was klinisch, vorklinisch oder Querschnittsfach sein kann und in der ÄAppO steht.");
    }

}