<?php

namespace Wertung\Domain\Skala;

class ProzentSkala implements Skala
{
    private static $singleton;

    public static function create() {
        if (!self::$singleton) {
            self::$singleton = new self();
        }
        return self::$singleton;
    }
}