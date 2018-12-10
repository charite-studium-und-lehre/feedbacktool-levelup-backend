<?php

namespace Pruefung\Domain;

use Common\Domain\DefaultEntityComparison;

class Pruefung
{
    use DefaultEntityComparison;

    /** @var PruefungsId */
    private $id;

    /** @var PruefungsDatum */
    private $datum;

    /** @var PruefungsFormat */
    private $format;

    /** @var ?Skala */
    private $benotungsSkala;

    public static function create(
        PruefungsId $id,
        PruefungsDatum $datum,
        PruefungsFormat $format,
        ?Skala $benotungsSakala = NULL
    ): self {

        $object = new self();
        $object->id = $id;
        $object->datum = $datum;
        $object->format = $format;
        $object->benotungsSkala = $benotungsSakala;

        return $object;
    }

    public function getId(): PruefungsId {
        return PruefungsId::fromInt($this->id->getValue());
    }

    public function getDatum(): PruefungsDatum {
        return $this->datum;
    }

    public function getFormat(): PruefungsFormat {
        return $this->format;
    }

}