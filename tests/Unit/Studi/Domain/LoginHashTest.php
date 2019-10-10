<?php

namespace Tests\Unit\Studi\Domain;

use PHPUnit\Framework\TestCase;
use Studi\Domain\LoginHash;

class LoginHashTest extends TestCase
{
    public function testFromString() {
        $value = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855';
        $object = LoginHash::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function testUngueltigeZeichen() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(LoginHash::UNGUELTIG);
        $value = '%e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855';
        LoginHash::fromString($value);
    }

    public function test_ZuLang() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(LoginHash::UNGUELTIG);
        $value = 'cf83e1357eefb8bdf1542850d66d8007d620e4050b5715dc83f4a921d36ce9ce47d0d13c5d85f2b0ff8318d2877eec2f63b931bd47417a81a538327af927da3e';
        LoginHash::fromString($value);
    }

    public function test_ZuKurz() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(LoginHash::UNGUELTIG);
        $value = 'd14a028c2a3a2bc9476102bb28';
        LoginHash::fromString($value);
    }
}