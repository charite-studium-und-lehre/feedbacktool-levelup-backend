<?php

namespace EPA\Infrastructure\Persistence\DB\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageKommentar;

class FremdBewertungsAnfrageKommentarType extends Type
{

    const TYPE_NAME = 'fremdBewertungsAnfrageKommentar'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "VARCHAR(" . FremdBewertungsAnfrageKommentar::MAX_LENGTH . ")";
    }

    /**
     * @param ?string $value
     * @return ?FremdBewertungsAnfrageKommentar
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return $value ? FremdBewertungsAnfrageKommentar::fromString($value) : NULL;
    }

    /**
     * @param ?FremdBewertungsAnfrageKommentar $value
     * @return ?string
     */
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