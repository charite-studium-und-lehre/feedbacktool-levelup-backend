<?php

namespace Pruefung\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Infrastructure\Persistence\DB\DoctrineTypes\AggregateIdStringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Pruefung\Domain\FrageAntwort\AntwortId;

class AntwortIdType extends AggregateIdStringType
{

    const TYPE_NAME = 'antwortId';

    /**
     * @param ?string $value
     * @return AntwortId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? AntwortId::fromString($value) : NULL;
    }
}