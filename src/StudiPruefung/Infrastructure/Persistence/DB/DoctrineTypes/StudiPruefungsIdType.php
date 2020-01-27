<?php

namespace StudiPruefung\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Infrastructure\Persistence\DB\DoctrineTypes\AggregateIdType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use StudiPruefung\Domain\StudiPruefungsId;

class StudiPruefungsIdType extends AggregateIdType
{

    const TYPE_NAME = 'studiPruefungsId'; // modify to match your type name

    /** @return StudiPruefungsId */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? StudiPruefungsId::fromInt($value) : NULL;
    }
}