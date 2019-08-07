<?php

namespace Cluster\Infrastructure\Persistence\DB;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterCode;
use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTitel;
use Cluster\Domain\ClusterTyp;
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

    public function byCode(ClusterCode $clusterCode): ?Cluster {
        return $this->doctrineRepo->findOneBy(
            ["code" => $clusterCode]
        );
    }

    public function nextIdentity(): ClusterId {
        return ClusterId::fromInt($this->abstractNextIdentityAsInt());
    }

    public function byClusterTypUndTitel(ClusterTyp $clusterTyp, ClusterTitel $clusterTitel): ?Cluster {
        return $this->doctrineRepo->findOneBy(
            [
                "clusterTyp.const" => $clusterTyp->getConst(),
                "titel.value" => $clusterTitel->getValue(),
            ]
        );
    }

    public function byClusterTypUndCode(ClusterTyp $clusterTyp, ClusterCode $clusterCode): ?Cluster {
        return $this->doctrineRepo->findOneBy(
            [
                "clusterTyp.const" => $clusterTyp->getConst(),
                "code" => $clusterCode,
            ]
        );
    }

    /** @return Cluster[] */
    public function allByClusterTyp(ClusterTyp $clusterTyp): array {
        return $this->doctrineRepo->findBy(
            [
                "clusterTyp.const" => $clusterTyp->getConst(),
            ]
        );
    }




}