<?php

namespace Pruefung\Infrastructure\Persistence\DB\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Pruefung\Domain\FrageAntwort\AntwortCode;

class AntwortCodeType extends Type
{

    const TYPE_NAME = 'antwortCode'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "VARCHAR(" . AntwortCode::MAX_LENGTH . ")";
    }

    /**
     * @param ?string $value
     * @return ?AntwortCode
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if ($value) {
            return AntwortCode::fromString($value);
        }

        return NULL;
    }

    /**
     * @param ?AntwortCode $value
     * @return ?string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }

        return $value->getValue();
    }

    public function getName() {
        return self::TYPE_NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}