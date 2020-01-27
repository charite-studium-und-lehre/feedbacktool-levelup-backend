<?php

namespace Pruefung\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Infrastructure\Persistence\DB\DoctrineTypes\AggregateIdStringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Pruefung\Domain\PruefungsId;

class PruefungsIdType extends AggregateIdStringType
{

    const TYPE_NAME = 'pruefungsId'; // modify to match your type name

    /**
     * @param ?string $value
     * @return PruefungsId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? PruefungsId::fromString($value) : NULL;
    }
}