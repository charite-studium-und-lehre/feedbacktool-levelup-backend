<?php

namespace Wertung\Domain;

use Cluster\Domain\ClusterTitel;
use Common\Domain\DDDEntity;
use StudiPruefung\Domain\StudiPruefungsId;
use Wertung\Domain\Wertung\WertungsInterface;

class ItemWertung implements DDDEntity
{
    /** @var ItemWertungsId */
    private $id;

    /** @var StudiPruefungsId */
    private $studiPruefungsId;

    /** @var ClusterTitel */
    private $titel;

    /** @var WertungsInterface */
    private $wertung;

    public static function create(
        ItemWertungsId $id,
        StudiPruefungsId $studiPruefungsId,
        WertungsInterface $wertung
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

    public function getWertung(): WertungsInterface {
        return $this->wertung;
    }

}