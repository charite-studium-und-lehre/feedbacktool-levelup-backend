<?php

namespace Studi\Infrastructure\Persistence\DB\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Studi\Domain\LoginHash;

class LoginHashType extends Type
{

    const TYPE_NAME = 'loginHash'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "VARCHAR(100)";
    }

    /**
     * @param ?string $value
     * @return ?LoginHash
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value
            ? LoginHash::fromString($value)
            : NULL;
    }

    /**
     * @param ?LoginHash $value
     * @return ?string
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