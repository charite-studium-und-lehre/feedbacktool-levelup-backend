<?php

namespace Cluster\Infrastructure\Persistence\DB;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTitel;
use Cluster\Domain\ClusterTypId;
use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;

final class DBClusterRepository implements ClusterRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(Cluster $cluster): void {
        $this->abstractDelete($cluster);
    }

    public function add(Cluster $cluster): void {
        $this->abstractAdd($cluster);
    }

    public function byId(ClusterId $clusterId): ?Cluster {
        return $this->abstractById($clusterId->getValue());
    }

    public function nextIdentity(): ClusterId {
        return ClusterId::fromInt($this->abstractNextIdentityAsInt());
    }

    public function byClusterTypIdUndTitel(ClusterTypId $clusterTypId, ClusterTitel $clusterTitel): ?Cluster {
        return $this->doctrineRepo->findOneBy(
            [
                "clusterTypId.id" => $clusterTypId->getValue(),
                "titel.value" => $clusterTitel->getValue(),
            ]
        );
    }

    /** @return Cluster[] */
    public function allByClusterTypId(ClusterTypId $clusterTypId): array {
        return $this->doctrineRepo->findBy(
            [
                "clusterTypId.id" => $clusterTypId->getValue(),
            ]
        );
    }
}