<?php

namespace Pruefung\Domain;

use Common\Domain\DefaultEntityComparison;
use Wertung\Domain\Skala\Skala;

class Pruefung
{
    use DefaultEntityComparison;

    private PruefungsId $id;

    private PruefungsPeriode $pruefungsPeriode;

    private PruefungsFormat $format;

    private ?Skala $benotungsSkala;

    public static function create(
        PruefungsId $id,
        PruefungsPeriode $pruefungsPeriode,
        PruefungsFormat $format,
        ?Skala $benotungsSakala = NULL
    ): self {

        $object = new self();
        $object->id = $id;
        $object->pruefungsPeriode = $pruefungsPeriode;
        $object->format = $format;
        $object->benotungsSkala = $benotungsSakala;

        return $object;
    }

    public function getId(): PruefungsId {
        return $this->id;
    }

    public function getPruefungsPeriode(): PruefungsPeriode {
        return $this->pruefungsPeriode;
    }

    public function getFormat(): PruefungsFormat {
        return $this->format;
    }

    public function getName(): string {
        return $this->getFormat()->getTitel() . " "
            . $this->getPruefungsPeriode()->getPeriodeBeschreibung();
    }

    public function getKurzName(): string {
        return $this->getFormat()->getTitelKurz() . $this->getPruefungsPeriode()->getPeriodeBeschreibungKurz();
    }

}