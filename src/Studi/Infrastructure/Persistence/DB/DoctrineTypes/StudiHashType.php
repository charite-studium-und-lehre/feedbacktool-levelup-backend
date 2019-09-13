<?php

namespace Studi\Infrastructure\Persistence\DB\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Studi\Domain\StudiHash;

class StudiHashType extends Type
{

    const TYPE_NAME = 'studiHash'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "VARCHAR(100)";
    }

    /** @return StudiHash */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? StudiHash::fromString($value) : NULL;
    }

    /** @param StudiHash $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        return ($value instanceof StudiHash) ? $value->getValue() : $value;
    }

    public function getName() {
        return self::TYPE_NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}