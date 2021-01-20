<?php

namespace Tests\Unit\Studi\Domain;

use PHPUnit\Framework\TestCase;
use Studi\Domain\StudiHash;

class StudiHashTest extends TestCase
{
    public function testFromString() {
        $value = '0062a008dbcd86fa8d0738e1f6e0f5daefe9fd2a7a9dddcacea008dbcd276d86';
        $object = StudiHash::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function testUngueltigeZeichen() {
        //$this->expectException(\InvalidArgumentException::class);
        // $this->expectExceptionMessage(StudiHash::UNGUELTIG);
        $this->expectException(\ValueError::class);
        $value = '%0062a008dbcd86fa8d0738e1f6e0f5daefe9fd2a7a9dddcace';
        StudiHash::fromString($value);
    }

    public function test_FalschZuLang() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(StudiHash::UNGUELTIG);
        $value = '0062a008dbcd86fa8d0738e1f6e0738e1f6e0f50f5daefe9fd2a7a9dddcace0062a008dbcd86fa8d0738e1f6e0f5daefe9fd2a7a9dddcace';
        StudiHash::fromString($value);
    }

    public function test_FalschZuKurz() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(StudiHash::UNGUELTIG);
        $value = '0062a008db';
        StudiHash::fromString($value);
    }
}