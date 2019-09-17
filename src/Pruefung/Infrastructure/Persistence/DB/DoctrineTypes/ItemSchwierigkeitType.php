<?php

namespace Pruefung\Infrastructure\Persistence\DB\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Pruefung\Domain\ItemSchwierigkeit;

class ItemSchwierigkeitType extends Type
{

    const TYPE_NAME = 'itemSchwierigkeit'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "INTEGER";
    }

    /** @return ItemSchwierigkeit */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if (is_int($value)) {
            return ItemSchwierigkeit::fromConst($value);
        }

        return NULL;
    }

    /** @param ItemSchwierigkeit $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }

        return $value->getConst();
    }

    public function getName() {
        return self::TYPE_NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}