<?php

namespace Common\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Domain\AggregateIdString;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class AggregateIdStringType extends Type
{

    const TYPE_NAME = 'aggregateIdString'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "VARCHAR(30)";
    }

    /**
     * @param ?string $value
     * @return ?AggregateIdString
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }

        return AggregateIdString::fromString($value);
    }

    /**
     * @param ?AggregateIdString $value
     * @return ?string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if (!$value instanceof AggregateIdString) {
            return NULL;
        }
        return $value->getValue();
    }

    /** @return string */
    public function getName(): string {
        return static::TYPE_NAME; // modify to match your constant name
    }

    /** @return bool */
    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}