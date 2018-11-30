<?php

namespace Tests\Unit\Cluster\Domain;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterTitel;
use Cluster\Domain\ClusterTypId;
use PHPUnit\Framework\TestCase;

class ClusterTest extends TestCase
{
    public function testCreate() {
        [$clusterId, $clusterTypId, $clusterTitel] = $this->createValueObjects();

        $cluster = Cluster::create($clusterId, $clusterTypId, $clusterTitel);

        $this->assertTrue($cluster->getId()->equals($clusterId));
        $this->assertTrue($cluster->getClusterTypId()->equals($clusterTypId));
        $this->assertTrue($cluster->getTitel()->equals($clusterTitel));
    }

    public function testCreateMitParent() {
        [$clusterId, $clusterTypId, $clusterTitel] = $this->createValueObjects();
        $parentId = ClusterId::fromInt(789);

        $cluster = Cluster::create($clusterId, $clusterTypId, $clusterTitel, $parentId);
        $this->assertTrue($cluster->getParentId()->equals($parentId));
    }

    /**
     * @return array
     */
    private function createValueObjects(): array {
        $clusterId = ClusterId::fromInt(123);
        $clusterTypId = ClusterTypId::fromInt(456);
        $clusterTitel = ClusterTitel::fromString("Klinische Fächer");
        return array($clusterId, $clusterTypId, $clusterTitel);
    }

}