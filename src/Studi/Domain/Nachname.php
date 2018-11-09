<?php

namespace Studi\Domain;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

final class Nachname
{
    use DefaultValueObjectComparison;

    const MIN_LENGTH = 2;
    const MAX_LENGTH = 30;

    const UNGUELTIG = "Der Nachname ist ungültig: ";
    const UNGUELTIG_ZU_KURZ = "Der Nachname ist zu kurz: ";
    const UNGUELTIG_ZU_LANG = "Der Nachname ist zu lang: ";

    private $value;

    public static function fromString(string $value): self {
        Assertion::String($value, self::UNGUELTIG);
        Assertion::alnum($value, self::UNGUELTIG);
        Assertion::minLength($value, self::MIN_LENGTH, self::UNGUELTIG_ZU_KURZ);
        Assertion::maxLength($value, self::MAX_LENGTH, self::UNGUELTIG_ZU_LANG);

        $object = new self();
        $object->value = $value;

        return $object;
    }

    public function getValue() {
        return $this->value;
    }

    public function __toString() {
        return $this->value;
    }

}