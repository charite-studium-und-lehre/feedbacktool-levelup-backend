<?php

namespace Pruefung\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Infrastructure\Persistence\DB\DoctrineTypes\AggregateIdStringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Pruefung\Domain\PruefungsItemId;

class PruefungsItemIdType extends AggregateIdStringType
{

    const TYPE_NAME = 'pruefungsItemId'; // modify to match your type name

    /**
     * @param ?string $value
     * @return ?PruefungsItemId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? PruefungsItemId::fromString($value) : NULL;
    }
}