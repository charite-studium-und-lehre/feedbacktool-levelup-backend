<?php

namespace Pruefung\Domain\FrageAntwort;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;
use Pruefung\Domain\PruefungsItemId;

class Frage implements DDDEntity
{
    use DefaultEntityComparison;

    private FragenId $id;

    private PruefungsItemId $pruefungsItemId;

    private FragenNummer $fragenNummer;

    private FragenText $fragenText;

    public static function fromPruefungsItemIdUndFrage(
        FragenId $fragenId,
        PruefungsItemId $pruefungsItemId,
        FragenNummer $fragenNummer,
        FragenText $fragenText
    ): self {
        $object = new self();
        $object->id = $fragenId;
        $object->pruefungsItemId = $pruefungsItemId;
        $object->fragenNummer = $fragenNummer;
        $object->fragenText = $fragenText;

        return $object;

    }

    public function getId(): FragenId {
        return FragenId::fromString($this->id);
    }

    public function getPruefungsItemId(): PruefungsItemId {
        return $this->pruefungsItemId;
    }

    public function getFragenNummer(): FragenNummer {
        return $this->fragenNummer;
    }

    public function setFragenNummer(FragenNummer $fragenNummer): void {
        $this->fragenNummer = $fragenNummer;
    }

    public function getFragenText(): FragenText {
        return $this->fragenText;
    }

    public function setFragenText(FragenText $fragenText): void {
        $this->fragenText = $fragenText;
    }

}