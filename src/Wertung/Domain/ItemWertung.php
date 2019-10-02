<?php

namespace Wertung\Domain;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;
use Pruefung\Domain\PruefungsItemId;
use StudiPruefung\Domain\StudiPruefungsId;
use Wertung\Domain\Wertung\Wertung;

class ItemWertung implements DDDEntity
{
    use DefaultEntityComparison;

    /** @var ItemWertungsId */
    private $id;

    /** @var PruefungsItemId */
    private $pruefungsItemId;

    /** @var StudiPruefungsId */
    private $studiPruefungsId;

    /** @var Wertung */
    private $wertung;

    public static function create(
        ItemWertungsId $id,
        PruefungsItemId $pruefungsItemId,
        StudiPruefungsId $studiPruefungsId,
        Wertung $wertung,
        bool $istGesamtErgebnis = FALSE
    ): self {
        $object = new self();
        $object->id = $id;
        $object->pruefungsItemId = $pruefungsItemId;
        $object->studiPruefungsId = $studiPruefungsId;
        $object->wertung = $wertung;
        $object->istGesamtErgebnis = $istGesamtErgebnis;

        return $object;
    }

    public function getId(): ItemWertungsId {
        return ItemWertungsId::fromInt($this->id);
    }

    public function getPruefungsItemId(): PruefungsItemId {
        return PruefungsItemId::fromString($this->pruefungsItemId);
    }

    public function getWertung(): Wertung {
        return $this->wertung;
    }

    public function setWertung(Wertung $wertung): void {
        $this->wertung = $wertung;
    }

    public function getStudiPruefungsId(): StudiPruefungsId {
        return StudiPruefungsId::fromInt($this->studiPruefungsId);
    }
}