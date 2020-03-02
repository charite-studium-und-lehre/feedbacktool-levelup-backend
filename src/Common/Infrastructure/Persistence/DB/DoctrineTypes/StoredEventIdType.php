<?php

namespace Common\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Application\AbstractEvent\StoredEventId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class StoredEventIdType extends AggregateIdType
{
    const TYPE_NAME = 'storedEventId'; // modify to match your type name

    /**
     * @param integer $value
     * @return StoredEventId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? StoredEventId::fromInt($value) : NULL;
    }

}