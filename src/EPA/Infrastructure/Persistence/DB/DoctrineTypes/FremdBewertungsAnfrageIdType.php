<?php

namespace EPA\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Infrastructure\Persistence\DB\DoctrineTypes\AggregateIdType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;

class FremdBewertungsAnfrageIdType extends AggregateIdType
{
    const TYPE_NAME = 'fremdBewertungsAnfrageId'; // modify to match your type name

    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? FremdBewertungsAnfrageId::fromInt($value) : NULL;
    }
}