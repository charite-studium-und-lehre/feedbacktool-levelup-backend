<?php

namespace Cluster\Infrastructure\Persistence\Filesystem;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterCode;
use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTitel;
use Cluster\Domain\ClusterTyp;
use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;

/** @method Array<Cluster> all() */
final class FileBasedSimpleClusterRepository extends AbstractCommonRepository implements ClusterRepository
{
    use FileBasedRepoTrait;

    public function byId(ClusterId $id): ?Cluster {
        return $this->abstractById($id);
    }

    public function byCode(ClusterCode $clusterCode): ?Cluster {
        foreach ($this->all() as $cluster) {
            if ($cluster->getCode() && $cluster->getCode()->equals($clusterCode)) {
                return $cluster;
            }
        }

        return NULL;
    }

    public function nextIdentity(): ClusterId {
        return ClusterId::fromInt($this->abstractNextIdentity()->getValue());
    }

    public function byClusterTypUndTitel(ClusterTyp $clusterTyp, ClusterTitel $clusterTitel): ?Cluster {
        foreach ($this->all() as $cluster) {
            if ($cluster->getClusterTyp()->equals($clusterTyp)
                && $cluster->getTitel()->equals($clusterTitel)) {
                return $cluster;
            }
        }

        return NULL;
    }

    public function byClusterTypUndCode(ClusterTyp $clusterTyp, ClusterCode $clusterCode): ?Cluster {
        foreach ($this->all() as $cluster) {
            if ($cluster->getClusterTyp()->equals($clusterTyp)
                && $cluster->getCode()
                && $cluster->getCode()->equals($clusterCode)) {
                return $cluster;
            }
        }

        return NULL;
    }

    /** @return Cluster[] */
    public function allByClusterTyp(ClusterTyp $clusterTyp): array {
        $returnArray = [];
        foreach ($this->all() as $cluster) {
            if ($cluster->getClusterTyp()->equals($clusterTyp)) {
                $returnArray[] = $cluster;
            }
        }

        return $returnArray;
    }

}
