<?php

namespace StudiPruefung\Domain;

use Common\Domain\DefaultEntityComparison;
use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiId;
use Wertung\Domain\Wertung\WertungsInterface;

class StudiPruefung
{
    /** StudiPruefungsId */
    private $id;

    /** @var StudiId */
    private $studiId;

    /** @var PruefungsId */
    private $pruefungsId;

    /** @var ?WertungsInterface */
    private $wertung;

    use DefaultEntityComparison;

    public static function fromValues(
        StudiPruefungsId $id,
        StudiId $studiId,
        PruefungsId $pruefungsId,
        WertungsInterface $wertung =
        NULL
    ) {
        $object = new self();
        $object->id = $id;
        $object->studiId = $studiId;
        $object->pruefungsId = $pruefungsId;
        $object->wertung = $wertung;

        return $object;
    }

    public function getId(): StudiPruefungsId {
        return $this->id;
    }

    public function getStudiId(): StudiId {
        return $this->studiId;
    }

    public function getPruefungsId(): PruefungsId {
        return $this->pruefungsId;
    }

    public function getWertung(): ?WertungsInterface {
        return $this->wertung;
    }

}