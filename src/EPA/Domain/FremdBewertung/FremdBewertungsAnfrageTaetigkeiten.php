<?php

namespace EPA\Domain\FremdBewertung;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class FremdBewertungsAnfrageTaetigkeiten implements DDDValueObject
{
    const MIN_LENGTH = 5;
    const MAX_LENGTH = 2_000;
    const UNGUELTIG_KURZ = "Die Angabe zu Tätigkeiten/Kurs muss - wenn gegeben - mindestens " . self::MIN_LENGTH . " Zeichen haben: ";
    const UNGUELTIG_LANG = "Die Angabe zu Tätigkeiten/Kurs der Anfrage darf höchstens " . self::MAX_LENGTH . " Zeichen haben: ";

    use DefaultValueObjectComparison;

    private string $value;

    public static function fromString(string $value): self {
        Assertion::String($value, "Ungültig: " . $value);
        Assertion::minLength($value, self::MIN_LENGTH, self::UNGUELTIG_KURZ . $value);
        Assertion::maxLength($value, self::MAX_LENGTH, self::UNGUELTIG_LANG . $value);

        $object = new self();
        $object->value = $value;

        return $object;
    }

    public function getValue(): string {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value;
    }

}