<?php

namespace Cluster\Domain;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

class ClusterTypTitel
{
    use DefaultValueObjectComparison;

    const MIN_TAG_LAENGE = 2;

    const MAX_TAG_LAENGE = 50;

    const INVALID_ZU_KURZ = "Der Clustertyptitel muss mindestens " . self::MIN_TAG_LAENGE . " Zeichen enthalten!";

    const INVALID_ZU_LANG = "Der Clustertyptitel darf maximal " . self::MAX_TAG_LAENGE . " Zeichen enthalten!";


    private $value;


    public static function fromString(string $value): self {
        Assertion::minLength($value, self::MIN_TAG_LAENGE, self::INVALID_ZU_KURZ);
        Assertion::maxLength($value, self::MAX_TAG_LAENGE, self::INVALID_ZU_LANG);

        $object = new self();
        $object->value = $value;

        return $object;
    }

    public function getValue(): string {
        return $this->value;
    }
}
