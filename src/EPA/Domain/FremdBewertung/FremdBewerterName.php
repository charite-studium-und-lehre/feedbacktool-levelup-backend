<?php

namespace EPA\Domain\FremdBewertung;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class FremdBewerterName implements DDDValueObject
{
    const MIN_LENGTH = 5;
    const MAX_LENGTH = 50;
    const UNGUELTIG_KURZ = "Der Name der/des Fremdbewerter/in muss mindestens " . self::MIN_LENGTH . " Zeichen haben: ";
    const UNGUELTIG_LANG = "Der Name der/des Fremdbewerter/in darf höchstens " . self::MAX_LENGTH . " Zeichen haben: ";

    use DefaultValueObjectComparison;

    /** @var string */
    private $value;

    public static function fromString(string $value): self {
        Assertion::String($value, self::UNGUELTIG_KURZ . $value);
        Assertion::minLength($value, self::MIN_LENGTH, self::UNGUELTIG_KURZ . $value);
        Assertion::maxLength($value, self::MAX_LENGTH, self::UNGUELTIG_LANG . $value);

        $object = new self();
        $object->value = $value;

        return $object;
    }

    public function getValue(): string {
        return $this->value;
    }

}