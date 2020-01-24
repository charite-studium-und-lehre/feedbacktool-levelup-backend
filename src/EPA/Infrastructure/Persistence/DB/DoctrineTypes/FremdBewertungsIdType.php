<?php

namespace EPA\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Infrastructure\Persistence\DB\DoctrineTypes\AggregateIdType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use EPA\Domain\FremdBewertung\FremdBewertungsId;

class FremdBewertungsIdType extends AggregateIdType
{
    const TYPE_NAME = 'fremdBewertungsId'; // modify to match your type name

    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? FremdBewertungsId::fromInt($value) : NULL;
    }
}