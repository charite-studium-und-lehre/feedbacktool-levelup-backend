<?php

namespace DatenImport\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Infrastructure\Persistence\DB\DoctrineTypes\AggregateIdType;
use DatenImport\Domain\LernzielNummer;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class LernzielNummerType extends AggregateIdType
{
    const TYPE_NAME = 'lernzielNummer';

    /**
     * @param int $value
     * @return ?LernzielNummer
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? LernzielNummer::fromInt($value) : NULL;
    }
}