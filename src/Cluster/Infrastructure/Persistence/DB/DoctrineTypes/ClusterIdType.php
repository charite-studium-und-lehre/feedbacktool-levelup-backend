<?php

namespace Cluster\Infrastructure\Persistence\DB\DoctrineTypes;

use Cluster\Domain\ClusterId;
use Common\Infrastructure\Persistence\DB\DoctrineTypes\AggregateIdType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class ClusterIdType extends AggregateIdType
{
    const TYPE_NAME = 'clusterId'; // modify to match your type name

    /**
     * @param int $value
     * @return ClusterId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? ClusterId::fromInt($value) : NULL;
    }
}