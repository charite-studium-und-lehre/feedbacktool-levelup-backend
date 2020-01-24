<?php

namespace EPA\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Infrastructure\Persistence\DB\DoctrineTypes\AggregateIdType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use EPA\Domain\SelbstBewertung\SelbstBewertungsId;

class SelbstBewertungsIdType extends AggregateIdType
{
    const TYPE_NAME = 'selbstBewertungsId'; // modify to match your type name

    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? SelbstBewertungsId::fromInt($value) : NULL;
    }
}