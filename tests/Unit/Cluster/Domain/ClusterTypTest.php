<?php

namespace Tests\Unit\Cluster\Domain;

use Cluster\Domain\ClusterTyp;
use Cluster\Domain\ClusterTypTitel;
use PHPUnit\Framework\TestCase;

class ClusterTypTest extends TestCase
{
    public function testCreate() {
        list($clusterTypId, $clusterTypTitel) = $this->createValueObjects();

        $cluster = ClusterTyp::create($clusterTypId, $clusterTypTitel);

        $this->assertTrue($cluster->getId()->equals($clusterTypId));
        $this->assertTrue($cluster->getTitel()->equals($clusterTypTitel));
    }

    public function testCreateMitParent() {
        list($clusterTypId, $clusterTypTitel) = $this->createValueObjects();

        $parentId = ClusterTyp::fromInt(789);

        $clusterTyp = ClusterTyp::create($clusterTypId, $clusterTypTitel, $parentId);
        $this->assertTrue($clusterTyp->getParentId()->equals($parentId));
    }

    /**
     * @return array
     */
    private function createValueObjects(): array {
        $clusterTypId = ClusterTyp::fromInt(456);
        $clusterTypTitel = ClusterTypTitel::fromString("Fach nach Klinikbezug");
        return array($clusterTypId, $clusterTypTitel);
    }

}