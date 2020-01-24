<?php

namespace Pruefung\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Infrastructure\Persistence\DB\DoctrineTypes\AggregateIdStringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Pruefung\Domain\FrageAntwort\AntwortCode;
use Pruefung\Domain\PruefungsId;

class PruefungsIdType extends AggregateIdStringType
{

    const TYPE_NAME = 'pruefungsId'; // modify to match your type name

    /** @return AntwortCode */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? PruefungsId::fromString($value) : NULL;
    }
}