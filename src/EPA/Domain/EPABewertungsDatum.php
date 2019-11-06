<?php

namespace EPA\Domain;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;
use DateTimeImmutable;
use InvalidArgumentException;

class EPABewertungsDatum
{
    use DefaultValueObjectComparison;

    const INVALID = "Ist kein gültiges Datum";

    /** @var DateTimeImmutable */
    private $value;

    public static function fromString(string $value): self {
        $datetimeImmutable = DateTimeImmutable::createFromFormat("d.m.Y", $value);
        if (!$datetimeImmutable) {
            throw new InvalidArgumentException(self::INVALID . $value);
        }

        return self::fromDateTimeImmutable($datetimeImmutable);
    }

    public static function fromDateTimeImmutable(DateTimeImmutable $value): self {

        $object = new self();
        Assertion::greaterThan($value->format("Y"), "2010",
                               self::INVALID . $value->format("d.m.Y"));
        Assertion::lessThan($value->format("Y"), "2100",
                            self::INVALID . $value->format("d.m.Y"));

        $object->value = DateTimeImmutable::createFromFormat(
            "d.m.Y H:i:s",
            $value->format("d.m.Y") . " 00:00:00"
        );

        return $object;
    }

    public static function heute(): self {
        return self::fromDateTimeImmutable(new DateTimeImmutable());
    }

    public function toDateTimeImmutable(): DateTimeImmutable {
        return clone $this->value;
    }

    public function toIsoString(): string {
        return $this->value->format("Y-m-d");
    }

    public function istNeuerAls(self $anderesBewertungsDatum): bool {
        return $this->value > $anderesBewertungsDatum->value;
    }

    public function __toString(): string {
        return $this->value->format("d.m.Y");
    }

    public function equals(object $otherObject): bool {
        $format = "d.m.Y";

        return $this->value->format($format)
            === $otherObject->value->format($format);
    }

}