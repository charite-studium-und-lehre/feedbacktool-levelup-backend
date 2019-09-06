<?php

namespace Pruefung\Domain;

use Assert\Assertion;
use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class PruefungsDatum implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const INVALID_PRUEFUNGSFORMAT = "Kein gültiges Datum (d.m.Y): ";

    /** @var \DateTimeImmutable */
    private $value;

    public static function fromString(string $value): self {
        $datetimeImmutable = \DateTimeImmutable::createFromFormat("d.m.Y", $value);
        if (!$datetimeImmutable) {
            throw new \InvalidArgumentException(self::INVALID_PRUEFUNGSFORMAT . $value);
        }

        return self::fromDateTimeImmutable($datetimeImmutable);
    }

    public static function fromDateTimeImmutable(\DateTimeImmutable $value): self {

        $object = new self();
        Assertion::greaterThan($value->format("Y"), "2010",
                               self::INVALID_PRUEFUNGSFORMAT . $value->format("d.m.Y"));
        Assertion::lessThan($value->format("Y"), "2100",
                            self::INVALID_PRUEFUNGSFORMAT . $value->format("d.m.Y"));
        $object->value = $value;

        return $object;
    }

    public function toDateTimeImmutable(): \DateTimeImmutable {
        return $this->value;
    }

    public function toIsoString(): string {
        return $this->value->format("Y-m-d");
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