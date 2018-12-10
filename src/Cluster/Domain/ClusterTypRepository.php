<?php

namespace Cluster\Domain;

use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;

interface ClusterTypRepository extends DDDRepository, FlushableRepository
{
    public function add(ClusterTyp $object): void;

    public function byId(ClusterTypId $id): ?ClusterTyp;

    /** @return ClusterTyp[] */
    public function all(): array;

    public function delete(ClusterTyp $object): void;

    public function nextIdentity(): ClusterTypId;
}
