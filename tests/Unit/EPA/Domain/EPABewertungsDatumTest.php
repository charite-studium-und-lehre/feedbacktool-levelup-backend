<?php

namespace Tests\Unit\EPA\Domain;

use EPA\Domain\EPABewertungsDatum;
use PHPUnit\Framework\TestCase;

class EPABewertungsDatumTest extends TestCase
{

    public function testFromDateTimeImmutable() {
        $date = new \DateTimeImmutable();
        $EPABewertungsDatum = EPABewertungsDatum::fromDateTimeImmutable($date);
        $this->assertEquals($EPABewertungsDatum->toDateTimeImmutable(), $date);
    }

    public function testFromDateTimeImmutable_FestesDatum() {
        $date = \DateTimeImmutable::createFromFormat("d.m.Y H:i:s", "2.9.2015 10:30:00");
        $EPABewertungsDatum = EPABewertungsDatum::fromDateTimeImmutable($date);
        $this->assertEquals($EPABewertungsDatum->toDateTimeImmutable(), $date);
    }

    public function testFromString_FalschesFormat() {
        $dateString = "2.9.2015 10:30:00";
        $this->expectExceptionMessage(EPABewertungsDatum::INVALID);
        EPABewertungsDatum::fromString($dateString);
    }

    public function testFromString() {
        $dateString = "2.9.2015";
        $EPABewertungsDatum = EPABewertungsDatum::fromString($dateString);
        $date = \DateTimeImmutable::createFromFormat("d.m.Y", $dateString);
        $this->assertEquals($EPABewertungsDatum->toDateTimeImmutable()->getTimestamp(), $date->getTimestamp());
    }

    public function testFromDateTimeImmutable_Falsch_ZuFrueh() {
        $date = \DateTimeImmutable::createFromFormat("Y-m-d", "2009-01-01");
        $this->expectExceptionMessage(EPABewertungsDatum::INVALID);
        EPABewertungsDatum::fromDateTimeImmutable($date);
    }

    public function testFromDateTimeImmutable_Falsch_ZuSpaet() {
        $date = \DateTimeImmutable::createFromFormat("Y-m-d", "2100-10-15");
        $this->expectExceptionMessage(EPABewertungsDatum::INVALID);
        EPABewertungsDatum::fromDateTimeImmutable($date);
    }

    public function testEquality() {
        $date1 = \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", "2020-10-15 10:30:10");
        $date2 = \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", "2020-10-15 12:45:20");
        $object1 = EPABewertungsDatum::fromDateTimeImmutable($date1);
        $object2 = EPABewertungsDatum::fromDateTimeImmutable($date2);
        $this->assertTrue($object1->equals($object2));
    }

    public function testEquality_ungleich() {
        $date1 = \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", "2020-10-15 10:30:10");
        $date2 = \DateTimeImmutable::createFromFormat("Y-m-d H:i:s", "2020-10-16 10:30:10");
        $object1 = EPABewertungsDatum::fromDateTimeImmutable($date1);
        $object2 = EPABewertungsDatum::fromDateTimeImmutable($date2);
        $this->assertFalse($object1->equals($object2));
    }

    public function testIsNeuer() {
        $this->assertTrue(
            EPABewertungsDatum::fromString("10.05.2017")
            ->istNeuerAls(EPABewertungsDatum::fromString("09.05.2017"))
        );
    }

    public function testIsAelter() {
        $this->assertFalse(
            EPABewertungsDatum::fromString("10.05.2017")
                ->istNeuerAls(EPABewertungsDatum::fromString("31.10.2019"))
        );
    }


}