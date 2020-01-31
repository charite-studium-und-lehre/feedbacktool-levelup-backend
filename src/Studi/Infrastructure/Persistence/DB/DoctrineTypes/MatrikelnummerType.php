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

    /**
     * @param ?int $value
     * @return ?Matrikelnummer
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value
            ? Matrikelnummer::fromInt($value)
            : NULL;
    }

    /**
     * @param ?Matrikelnummer $value
     * @return ?int
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        return $value
            ? $value->getValue()
            : NULL;
    }

    public function getName() {
        return self::TYPE_NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}