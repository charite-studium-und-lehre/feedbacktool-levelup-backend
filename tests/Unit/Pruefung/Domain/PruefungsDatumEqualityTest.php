<?php

namespace Tests\Unit\Pruefung\Domain;

use PHPUnit\Framework\TestCase;
use Pruefung\Domain\PruefungsDatum;

class PruefungsDatumEqualityTest extends TestCase
{

    public function testEquality() {
        $date1 = \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", "2020-10-15 10:30:10");
        $date2 = \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", "2020-10-15 12:45:20");
        $pruefungsDatum1 = PruefungsDatum::fromDateTimeImmutable($date1);
        $pruefungsDatum2 = PruefungsDatum::fromDateTimeImmutable($date2);
        $this->assertTrue($pruefungsDatum1->equals($pruefungsDatum2));

    }

    public function testEquality_ungleich() {
        $date1 = \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", "2020-10-15 10:30:10");
        $date2 = \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", "2020-10-16 10:30:10");
        $pruefungsDatum1 = PruefungsDatum::fromDateTimeImmutable($date1);
        $pruefungsDatum2 = PruefungsDatum::fromDateTimeImmutable($date2);
        $this->assertFalse($pruefungsDatum1->equals($pruefungsDatum2));

    }

}