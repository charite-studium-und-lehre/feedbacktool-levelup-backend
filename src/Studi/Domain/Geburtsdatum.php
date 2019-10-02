<?php

namespace Studi\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;
use DateTimeImmutable;

final class Geburtsdatum implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const MIN_JAHR = 1950;
    const MAX_JAHR = 2100;
    const UNGUELTIG = "Das Geburtsdatum ist ungültig: ";
    const UNGUELTIG_JAHR = "Das Geburtsjahr liegt nicht zwischen " . self::MIN_JAHR . " und " . self::MAX_JAHR . ":";
    const DATUMS_FORMAT_DEUTSCH = "d.m.Y";
    const DATUMS_FORMAT_DEUTSCH_MINUS = "d-m-Y";

    /** @var DateTimeImmutable */
    private $value;

    public static function fromDateTimeImmutable(DateTimeImmutable $date): self {
        Assertion::min($date->format("Y"), self::MIN_JAHR, self::UNGUELTIG_JAHR . $date->format("d.m.Y"));
        Assertion::max($date->format("Y"), self::MAX_JAHR, self::UNGUELTIG_JAHR . $date->format("d.m.Y"));

        $object = new self();
        $object->value = $date;

        return $object;
    }

    public static function fromStringDeutsch(string $dateString): self {
        Assertion::date($dateString, self::DATUMS_FORMAT_DEUTSCH, self::UNGUELTIG . $dateString);

        return self::fromDateTimeImmutable(
            DateTimeImmutable::createFromFormat(self::DATUMS_FORMAT_DEUTSCH, $dateString)
        );
    }

    public static function fromStringDeutschMinus(string $dateString): self {
        Assertion::date($dateString, self::DATUMS_FORMAT_DEUTSCH_MINUS, self::UNGUELTIG . $dateString);

        return self::fromDateTimeImmutable(
            DateTimeImmutable::createFromFormat(self::DATUMS_FORMAT_DEUTSCH_MINUS, $dateString)
        );
    }

    public function getValue(): DateTimeImmutable {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value->format(self::DATUMS_FORMAT_DEUTSCH);
    }

}