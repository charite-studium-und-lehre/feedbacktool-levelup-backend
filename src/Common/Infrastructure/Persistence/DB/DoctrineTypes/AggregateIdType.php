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

    /**
     * @param ?int $value
     * @return ?AggregateId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value
            ? AggregateId::fromInt($value)
            : NULL;
    }

    /**
     * @param ?AggregateId $value
     * @return ?int
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        return $value
            ? $value->getValue()
            : NULL;
    }

    /** @return string */
    public function getName() {
        return static::TYPE_NAME; // modify to match your constant name
    }

    /** @return bool */
    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}