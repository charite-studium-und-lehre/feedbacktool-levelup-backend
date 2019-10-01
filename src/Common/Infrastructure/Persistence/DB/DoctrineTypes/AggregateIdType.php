<?php

namespace Common\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Domain\AggregateId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class AggregateIdType extends Type
{

    const AGGREGATE_ID_TYPE = 'aggregateId'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "INTEGER";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return null;
        }
        return AggregateId::fromInt($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if ($value instanceof AggregateId) {
            return $value->getValue();
            echo "1";
        } else {
            return $value;
            echo "2";
        }
    }

    public function getName() {
        return self::AGGREGATE_ID_TYPE; // modify to match your constant name
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}