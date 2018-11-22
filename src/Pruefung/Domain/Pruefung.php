<?php

namespace Pruefung\Domain;

use Common\Domain\DefaultEntityComparison;
use Common\Domain\HatEntityZeitstempel;
use Common\Domain\HatEntityZeitstempelTrait;

class Pruefung implements HatEntityZeitstempel
{
    use HatEntityZeitstempelTrait;
    use DefaultEntityComparison;

    /** @var PruefungId */
    private $id;

    /** @var Pruefungsformat */
    private $format;



    public static function create(PruefungId $id, Pruefungsformat $format) {


        $object = new self();
        $object->id = $id;
        $object->format = $format;
        $object->erzeugeZeitstempel();

        return $object;
    }

    public function getId(){
        return PruefungId::fromInt($this->id->getValue());
    }

    public function getPruefungsFormat(){
        return $this->format;
    }

}