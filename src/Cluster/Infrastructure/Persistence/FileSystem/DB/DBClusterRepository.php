<?php

namespace Cluster\Infrastructure\Persistence\DB;

use Cluster\Domain\ClusterRepository;
use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterId;

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

}