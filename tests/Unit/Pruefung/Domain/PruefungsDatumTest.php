<?php

namespace Tests\Unit\Pruefung\Domain;

use PHPUnit\Framework\TestCase;
use Pruefung\Domain\PruefungsPeriode;

class PruefungsDatumTest extends TestCase
{

    public function testFromDateTimeImmutable() {
        $date = new \DateTimeImmutable();
        $pruefungsdatum = PruefungsPeriode::fromDateTimeImmutable($date);
        $this->assertEquals($pruefungsdatum->toDateTimeImmutable(), $date);
    }

    public function testFromDateTimeImmutable_FestesDatum() {
        $date = \DateTimeImmutable::createFromFormat("d.m.Y H:i:s", "2.9.2015 10:30:00");
        $pruefungsdatum = PruefungsPeriode::fromDateTimeImmutable($date);
        $this->assertEquals($pruefungsdatum->toDateTimeImmutable(), $date);
    }

    public function testFromString_FalschesFormat() {
        $dateString = "2.9.2015 10:30:00";
        $this->expectExceptionMessage(PruefungsPeriode::INVALID_PRUEFUNGSDATUM);
        PruefungsPeriode::fromString($dateString);
    }

    public function testFromString() {
        $dateString = "2.9.2015";
        $pruefungsdatum = PruefungsPeriode::fromString($dateString);
        $date = \DateTimeImmutable::createFromFormat("d.m.Y", $dateString);
        $this->assertEquals($pruefungsdatum->toDateTimeImmutable()->getTimestamp(), $date->getTimestamp());
    }

    public function testFromDateTimeImmutable_Falsch_ZuFrueh() {
        $date = \DateTimeImmutable::createFromFormat("Y-m-d", "2009-01-01");
        $this->expectExceptionMessage(PruefungsPeriode::INVALID_PRUEFUNGSDATUM);
        PruefungsPeriode::fromDateTimeImmutable($date);
    }

    public function testFromDateTimeImmutable_Falsch_ZuSpaet() {
        $date = \DateTimeImmutable::createFromFormat("Y-m-d", "2100-10-15");
        $this->expectExceptionMessage(PruefungsPeriode::INVALID_PRUEFUNGSDATUM);
        PruefungsPeriode::fromDateTimeImmutable($date);
    }

}