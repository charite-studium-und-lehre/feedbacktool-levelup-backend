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

    public function byClusterTypIdUndTitel(ClusterTypId $clusterTypId, ClusterTitel $clusterTitel): ?Cluster;

    /** @return Cluster[] */
    public function allByClusterTypId(ClusterTypId $clusterTypId): array;

    public function nextIdentity(): ClusterId;
}
