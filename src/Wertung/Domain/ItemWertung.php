<?php

namespace Wertung\Domain;

use Common\Domain\DDDEntity;
use StudiPruefung\Domain\StudiPruefungsId;

class ItemWertung implements DDDEntity
{
    /** @var ItemWertungsId */
    private $id;

    /** @var StudiPruefungsId */
    private $studiPruefungsId;

    /** @var ClusterTitel */
    private $titel;

    /** @var Wertung */
    private $wertung;

    public static function create(
        ItemWertungsId $id,
        StudiPruefungsId $studiPruefungsId,
        Wertung $wertung
    ): self {
        $object = new self();
        $object->id = $id;
        $object->wertung = $wertung;

        return $object;
    }

    public function getId(): ItemWertungsId {
        return $this->id;
    }

    public function getStudiPruefungsId(): StudiPruefungsId {
        return $this->studiPruefungsId;
    }

    public function getTitel(): ClusterTitel {
        return $this->titel;
    }

    public function getWertung(): Wertung {
        return $this->wertung;
    }

}