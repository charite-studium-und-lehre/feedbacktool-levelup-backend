<?php

namespace Common\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\Domain\AggregateId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class AggregateIdAIType extends AggregateIdType
{

    const AGGREGATE_ID_AI_TYPE = 'aggregateId_AutoIncrement'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "INTEGER AUTO_INCREMENT";
    }

    public function getName() {
        return self::AGGREGATE_ID_AI_TYPE; // modify to match your constant name
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}