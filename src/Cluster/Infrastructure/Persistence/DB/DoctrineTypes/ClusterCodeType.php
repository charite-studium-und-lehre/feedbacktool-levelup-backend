<?php

namespace Cluster\Infrastructure\Persistence\DB\DoctrineTypes;

use Cluster\Domain\ClusterCode;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ClusterCodeType extends Type
{

    const TYPE_NAME = 'clusterCode'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "VARCHAR(" . ClusterCode::MAX_TAG_LAENGE . ")";
    }

    /** @return ClusterCode */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? ClusterCode::fromString($value) : NULL;
    }

    /** @param ?ClusterCode $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        return $value ? $value->getValue() : NULL;
    }

    public function getName() {
        return self::TYPE_NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}