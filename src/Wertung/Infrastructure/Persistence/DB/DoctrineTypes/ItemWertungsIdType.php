<?php

namespace Wertung\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Infrastructure\Persistence\DB\DoctrineTypes\AggregateIdType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Wertung\Domain\ItemWertungsId;

class ItemWertungsIdType extends AggregateIdType
{
    const TYPE_NAME = 'itemWertungsId'; // modify to match your type name

    /**
     * @param $value integer
     * @return ItemWertungsId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? ItemWertungsId::fromInt($value) : NULL;
    }

}