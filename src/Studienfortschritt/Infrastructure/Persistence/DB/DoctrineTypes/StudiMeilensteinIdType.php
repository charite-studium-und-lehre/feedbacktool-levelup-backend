<?php

namespace Studienfortschritt\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Infrastructure\Persistence\DB\DoctrineTypes\AggregateIdType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Studienfortschritt\Domain\StudiMeilensteinId;
use StudiPruefung\Domain\StudiPruefungsId;

class StudiMeilensteinIdType extends AggregateIdType
{

    const TYPE_NAME = 'studiMeilensteinId'; // modify to match your type name

    /**
     * @param ?int $value
     * @return ?StudiMeilensteinId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? StudiMeilensteinId::fromInt($value) : NULL;
    }
}