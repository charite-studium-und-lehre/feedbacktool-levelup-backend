<?php

namespace Studi\Domain;

use Common\Domain\DefaultEntityComparison;

class Studi
{
    use DefaultEntityComparison;

    /** @var Vorname */
    private $vorname;

    /** @var Nachname */
    private $nachname;

    /** @var Email */
    private $email;

    /** @var MatrikelHash */
    private $matrikelhash;

    public static function fromValues(Vorname $vorname, Nachname $nachname, Email $email, MatrikelHash $matrikelHash) {
        $object = new self();
        $object->vorname = $vorname;
        $object->nachname = $nachname;
        $object->email = $email;
        $object->matrikelhash = $matrikelHash;
        return $object;
    }

}