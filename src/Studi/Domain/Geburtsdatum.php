<?php

namespace Studi\Domain;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

final class Geburtsdatum
{
    use DefaultValueObjectComparison;

    const MIN_JAHR = 1950;
    const MAX_JAHR = 2100;
    const UNGUELTIG = "Das Geburtsdatum ist ungültig: ";
    const UNGUELTIG_JAHR = "Das Geburtsjahr liegt nicht zwischen " . self::MIN_JAHR . " und " . self::MAX_JAHR . ":";
    const DATUMS_FORMAT = "d.m.Y";

    private $value;

    public static function fromDateTimeImmutable(\DateTimeImmutable $date): self {
        Assertion::min($date->format("Y"), self::MIN_JAHR, self::UNGUELTIG_JAHR);
        Assertion::max($date->format("Y"), self::MAX_JAHR, self::UNGUELTIG_JAHR);

        $object = new self();
        $object->value = $date;

        return $object;
    }

    public static function fromStringDeutsch(string $dateString): self {
        Assertion::date($dateString, self::DATUMS_FORMAT);
        return self::fromDateTimeImmutable(
            \DateTimeImmutable::createFromFormat(self::DATUMS_FORMAT, $dateString)
        );
    }

    public function getValue() {
        return $this->value;
    }

    public function __toString() {
        return $this->value;
    }

}