<?php

namespace Wertung\Domain;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;
use Exception;
use Pruefung\Domain\FrageAntwort\AntwortCode;
use Pruefung\Domain\PruefungsItemId;
use StudiPruefung\Domain\StudiPruefungsId;
use Wertung\Domain\Wertung\Wertung;

class ItemWertung implements DDDEntity
{
    use DefaultEntityComparison;

    private ItemWertungsId $id;

    private PruefungsItemId $pruefungsItemId;

    private StudiPruefungsId $studiPruefungsId;

    private Wertung $wertung;

    private ?Wertung $kohortenWertung;

    private ?AntwortCode $antwortCode;

    public static function create(
        ItemWertungsId $id,
        PruefungsItemId $pruefungsItemId,
        StudiPruefungsId $studiPruefungsId,
        Wertung $wertung,
        ?AntwortCode $antwortCode = NULL
    ): self {
        $object = new self();
        $object->id = $id;
        $object->pruefungsItemId = $pruefungsItemId;
        $object->studiPruefungsId = $studiPruefungsId;
        $object->wertung = $wertung;
        $object->antwortCode = $antwortCode;

        return $object;
    }

    public function getKohortenWertung(): ?Wertung {
        return $this->kohortenWertung;
    }

    public function setKohortenWertung(?Wertung $kohortenWertung): void {
        if (get_class($kohortenWertung) != get_class($this->wertung)) {
            throw new Exception("Kohortenwertung muss gleiche Wertungsart sein wie Wertung selbst!");
        }
        $this->kohortenWertung = $kohortenWertung;
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

    public function getAntwortCode(): ?AntwortCode {
        return $this->antwortCode;
    }
}