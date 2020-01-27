<?php

namespace Wertung\Domain\Skala;

use Common\Domain\DefaultValueObjectComparison;

class ProzentSkala implements Skala
{
    use DefaultValueObjectComparison;

    private static ProzentSkala $singleton;

    public static function create(): ProzentSkala {
        if (!self::$singleton) {
            self::$singleton = new self();
        }

        return self::$singleton;
    }
}