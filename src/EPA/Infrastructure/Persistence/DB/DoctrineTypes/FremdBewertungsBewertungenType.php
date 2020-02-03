<?php

namespace EPA\Infrastructure\Persistence\DB\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use EPA\Domain\EPA;
use EPA\Domain\EPABewertung;

class FremdBewertungsBewertungenType extends Type
{

    const TYPE_NAME = 'fremdBewertungsBewertungen'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "VARCHAR(300)";
    }

    /**
     * @param ?string $value
     * @return ?EPABewertung[]
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }
        $arrayOfValues = json_decode($value);
        $returnArray = [];
        foreach ($arrayOfValues as $epaNummer => $epaBewertungsInt) {
            $returnArray[] = EPABewertung::fromValues(
                $epaBewertungsInt,
                EPA::fromInt($epaNummer)
            );
        }

        return $returnArray;
    }

    /**
     * @param ?EPABewertung[] $value
     * @return void
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if (!is_array($value)) {
            return NULL;
        }
        $valueArray = [];
        foreach ($value as $epaBewertung) {
            /** @var EPABewertung $epaBewertung */
            $valueArray[$epaBewertung->getEpa()->getNummer()] = $epaBewertung->getBewertungInt();
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