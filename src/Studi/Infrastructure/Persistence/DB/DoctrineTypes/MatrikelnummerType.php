<?php

namespace Studi\Infrastructure\Persistence\DB\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Studi\Domain\Matrikelnummer;

class MatrikelnummerType extends Type
{

    const TYPE_NAME = 'matrikelnummer'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "INTEGER";
    }

    /** @return Matrikelnummer */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return Matrikelnummer::fromInt($value);
    }

    /** @param Matrikelnummer $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        return $value->getValue();
    }

    public function getName() {
        return self::TYPE_NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}