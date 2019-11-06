<?php

namespace EPA\Infrastructure\Persistence\DB\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use EPA\Domain\EPABewertung;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageTaetigkeiten;

class FremdBewertungsBewertungenType extends Type
{

    const TYPE_NAME = 'fremdBewertungsBewertungen'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "VARCHAR(300)";
    }

    /** @return EPABewertung[] */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }
        $arrayOfValues = json_decode($value);
        $returnArray = [];
        foreach ($arrayOfValues as $bewertungsArray) {
            $returnArray[] = EPABewertung::unserializeFromArray($bewertungsArray);
        }
        return $returnArray;
    }

    /** @param EPABewertung[] $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }
        $valueArray = [];
        foreach ($value as $epaBewertung) {
            $valueArray[] = $epaBewertung->serializeToArray();
        }
        return json_encode($valueArray);
    }

    public function getName() {
        return self::TYPE_NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}