<?php

namespace Common\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Domain\AggregateId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class AggregateIdType extends Type
{
    const TYPE_NAME = 'aggregateId'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "INTEGER";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }
        return AggregateId::fromInt($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if ($value instanceof AggregateId) {
            return $value->getValue();
        } else {
            return $value;
        }
    }

    public function getName() {
        return static::TYPE_NAME; // modify to match your constant name
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}