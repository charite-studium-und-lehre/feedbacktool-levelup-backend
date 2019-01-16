<?php

namespace Cluster\Infrastructure\Persistence\Filesystem;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterRepository;
use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Lehrberechtigung\Infrastructure\Persistence\Common\AbstractSimpleLehrberechtigungRepository;

final class FileBasedSimpleClusterRepository extends AbstractCommonRepository implements ClusterRepository
{
    use FileBasedRepoTrait;

    public function byId(ClusterId $id): ?Cluster {
        return $this->abstractById($id);
    }

    public function nextIdentity(): ClusterId {
        return $this->abstractNextIdentity();
    }
}
