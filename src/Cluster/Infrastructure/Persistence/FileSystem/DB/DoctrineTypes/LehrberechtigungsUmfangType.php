<?php

namespace Lehrberechtigung\Infrastructure\Persistence\DB\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Lehrberechtigung\Domain\LehrberechtigungsUmfang;

class LehrberechtigungsUmfangType extends Type
{

    const TYPE_ID = 'lehrberechtigungsUmfang'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "INTEGER";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }

        return LehrberechtigungsUmfang::fromInt($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if ($value instanceof LehrberechtigungsUmfang) {
            return $value->getStundenzahl();
        }
    }

    public function getName() {
        return self::TYPE_ID; // modify to match your constant name
    }
}