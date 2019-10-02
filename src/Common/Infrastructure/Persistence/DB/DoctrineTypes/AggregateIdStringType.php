<?php

namespace Common\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Domain\AggregateIdString;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class AggregateIdStringType extends Type
{

    const AGGREGATE_ID_STRING_TYPE = 'aggregateIdString'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "VARCHAR(30)";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }

        return AggregateIdString::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }
        if ($value instanceof AggregateIdString) {
            return $value->getValue();
        } else {
            return $value;
        }
    }

    public function getName() {
        return self::AGGREGATE_ID_STRING_TYPE; // modify to match your constant name
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}