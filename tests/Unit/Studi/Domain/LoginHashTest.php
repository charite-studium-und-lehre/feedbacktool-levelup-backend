<?php

namespace Tests\Unit\Studi\Domain;

use PHPUnit\Framework\TestCase;
use Studi\Domain\LoginHash;

class LoginHashTest extends TestCase
{
    public function testFromString() {
        $value = '$argon2i$v=19$m=1024,t=2,p=2$UzVMRDgucWZCcHpteWE5UA$KS47cztpT3SAzMWRyaIz1sX9uUa6GQ4KT0GSNMXzJ2I';
        $object = LoginHash::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function testUngueltigeZeichen() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(LoginHash::UNGUELTIG);
        $value = '$argon2"i$v=19$m=1024,t=2,p=2$UzVMRDgucWZCcHpteWE5UA$KS47cztpT3SAzMWRyaIz1sX9uUa6GQ4KT0GSNMXzJ2I';
        LoginHash::fromString($value);
    }

    public function test_ZuLang() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(LoginHash::UNGUELTIG);
        $value = '$argon2i$v=19$m=1024,t=2,p=2$UzVMRDgucWZCcHpteWE5UA$KS47cztpT3SAzMWRyaIz1sX9uUa6GQ4KT0GSNMXzJ2I2$UzVMRDgucWZCcHpteWE5UA$KS47cztpT3SAzMWRyaIz1sX9uUa6GQ4KT0GSNMXzJ2I';
        LoginHash::fromString($value);
    }

    public function test_ZuKurz() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(LoginHash::UNGUELTIG);
        $value = '$argon2i$v=19$m=1024';
        LoginHash::fromString($value);
    }
}