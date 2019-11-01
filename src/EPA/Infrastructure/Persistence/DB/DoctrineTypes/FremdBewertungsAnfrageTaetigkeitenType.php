<?php

namespace EPA\Infrastructure\Persistence\DB\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageTaetigkeiten;

class FremdBewertungsAnfrageTaetigkeitenType extends Type
{

    const TYPE_NAME = 'fremdBewertungsAnfrageTaetigkeiten'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "VARCHAR(" . FremdBewertungsAnfrageTaetigkeiten::MAX_LENGTH . ")";
    }

    /** @return FremdBewertungsAnfrageTaetigkeiten */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? FremdBewertungsAnfrageTaetigkeiten::fromString($value) : NULL;
    }

    /** @param FremdBewertungsAnfrageTaetigkeiten $value */
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