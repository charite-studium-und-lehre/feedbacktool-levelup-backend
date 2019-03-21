<?php

namespace Tests\Unit\Studi\Domain;

use PHPUnit\Framework\TestCase;
use Studi\Domain\StudiHash;

class StudiHashTest extends TestCase
{
    public function testFromString() {
        $value = '$argon2i$v=19$m=1024,t=2,p=2$UzVMRDgucWZCcHpteWE5UA$KS47cztpT3SAzMWRyaIz1sX9uUa6GQ4KT0GSNMXzJ2I';
        $object = StudiHash::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function testUngueltigeZeichen() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(StudiHash::UNGUELTIG);
        $value = '$argon2"i$v=19$m=1024,t=2,p=2$UzVMRDgucWZCcHpteWE5UA$KS47cztpT3SAzMWRyaIz1sX9uUa6GQ4KT0GSNMXzJ2I';
        StudiHash::fromString($value);
    }

    public function test_FalschZuLang() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(StudiHash::UNGUELTIG);
        $value = '$argon2i$v=19$m=1024,t=2,p=2$UzVMRDgucWZCcHpteWE5UA$KS47cztpT3SAzMWRyaIz1sX9uUa6GQ4KT0GSNMXzJ2I2$UzVMRDgucWZCcHpteWE5UA$KS47cztpT3SAzMWRyaIz1sX9uUa6GQ4KT0GSNMXzJ2I';
        StudiHash::fromString($value);
    }

    public function test_FalschZuKurz() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(StudiHash::UNGUELTIG);
        $value = '$argon2i$v=19$m=1024';
        StudiHash::fromString($value);
    }
}