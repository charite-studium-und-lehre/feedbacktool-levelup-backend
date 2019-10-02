<?php

namespace Pruefung\Infrastructure\Persistence\DB\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Pruefung\Domain\PruefungsPeriode;

class PruefungsPeriodeType extends Type
{

    const TYPE_NAME = 'pruefungsPeriode'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "INTEGER";
    }

    /** @return PruefungsPeriode */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if (is_numeric($value)) {
            return PruefungsPeriode::fromInt($value);
        }

        return NULL;
    }

    /** @param PruefungsPeriode $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }

        return $value->toInt();
    }

    public function getName() {
        return self::TYPE_NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}