<?php

namespace Pruefung\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Infrastructure\Persistence\DB\DoctrineTypes\AggregateIdStringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Pruefung\Domain\FrageAntwort\FragenId;

class FragenIdType extends AggregateIdStringType
{

    const TYPE_NAME = 'fragenId';

    /**
     * @param ?string $value
     * @return FragenId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? FragenId::fromString($value) : NULL;
    }
}