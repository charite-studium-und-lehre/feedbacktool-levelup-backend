<?php

namespace Cluster\Domain;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;

interface ClusterRepository extends DDDRepository, FlushableRepository
{
    public function add(Cluster $object): void;

    public function byId(ClusterId $id): ?Cluster;

    /** @return Cluster[] */
    public function all(): array;

    public function delete(Cluster $object): void;

    public function byCode(ClusterCode $clusterCode): ?Cluster;

    public function byClusterTypUndTitel(ClusterTyp $clusterTyp, ClusterTitel $clusterTitel): ?Cluster;

    public function byClusterTypUndCode(ClusterTyp $clusterTyp, ClusterCode $clusterCode): ?Cluster;

    /** @return Cluster[] */
    public function allByClusterTyp(ClusterTyp $clusterTyp): array;

    public function nextIdentity(): ClusterId;
}
