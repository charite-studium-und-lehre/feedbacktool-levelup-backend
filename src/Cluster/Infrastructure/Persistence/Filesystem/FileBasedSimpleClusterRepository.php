<?php

namespace Cluster\Infrastructure\Persistence\Filesystem;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTitel;
use Cluster\Domain\ClusterTypId;
use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Lehrberechtigung\Infrastructure\Persistence\Common\AbstractSimpleLehrberechtigungRepository;

/** @method Cluster[] all() */
final class FileBasedSimpleClusterRepository extends AbstractCommonRepository implements ClusterRepository
{
    use FileBasedRepoTrait;

    public function byId(ClusterId $id): ?Cluster {
        return $this->abstractById($id);
    }

    public function nextIdentity(): ClusterId {
        return ClusterId::fromInt($this->abstractNextIdentity());
    }

    public function byClusterTypIdUndTitel(ClusterTypId $clusterTypId, ClusterTitel $clusterTitel): ?Cluster {
        foreach ($this->all() as $cluster) {
            if ($cluster->getClusterTypId()->equals($clusterTypId)
                && $cluster->getTitel()->equals($clusterTitel)) {
                return $cluster;
            }
        }
        return NULL;
    }

    /** @return Cluster[] */
    public function allByClusterTypId(ClusterTypId $clusterTypId): array {
        $returnArray = [];
        foreach ($this->all() as $cluster) {
            if ($cluster->getClusterTypId()->equals($clusterTypId)) {
                $returnArray[] = $cluster;
            }
        }

        return $returnArray;
    }
}
