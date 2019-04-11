<?php

namespace Wertung\Infrastructure\Persistence\DB\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Wertung\Domain\Skala\ProzentSkala;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Skala\Skala;
use Wertung\Domain\Wertung\Punktzahl;

/** @TODO: unused */
class SkalaType extends Type
{

    const TYPE_NAME = 'wertungsSkala'; // modify to match your type name

    const PUNKT_SKALA = 1;
    const PROZENT_SKALA = 2;

    const AMOUNT_FACTOR = 100;

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "INTEGER";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return null;
        }
        $type = $value % self::AMOUNT_FACTOR;
        $amount = $value / self::AMOUNT_FACTOR;
        $class = null;
        switch ($type) {
            case 10:
                return ProzentSkala::create();
                break;
            case 20:
                return PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat($amount));
                break;
        }
        throw new \Exception("Skala-Typ aus DB '$type' nicht bekannt!'");
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if (!$value instanceof Skala) {
            throw new \Exception("Skala-Typ muss Interface 'Skala' implementieren");
        }
        if ($value instanceof ProzentSkala) {
            return self::PROZENT_SKALA;
        } elseif ($value instanceof PunktSkala) {
            return self::AMOUNT_FACTOR * $value->getMaxPunktzahl()->getValue() + self::PUNKT_SKALA;
        }
        throw new \Exception("Skala-Typ '" . get_class($value) . "'ist unbekannt!");
    }

    public function getName() {
        return self::TYPE_NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}