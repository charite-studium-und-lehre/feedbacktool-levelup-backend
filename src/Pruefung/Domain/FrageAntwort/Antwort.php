<?php

namespace Pruefung\Domain\FrageAntwort;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;

class Antwort implements DDDEntity
{
    use DefaultEntityComparison;

    private AntwortId $id;

    private FragenId $fragenId;

    private AntwortCode $antwortCode;

    private AntwortText $antwortText;

    private bool $istRichtig;

    public static function fromPruefungsItemIdUndFragenId(
        AntwortId $antwortId,
        FragenId $fragenId,
        AntwortCode $antwortCode,
        AntwortText $antwortText,
        bool $istRichtig
    ): self {
        $object = new self();
        $object->id = $antwortId;
        $object->fragenId = $fragenId;
        $object->antwortCode = $antwortCode;
        $object->antwortText = $antwortText;
        $object->istRichtig = $istRichtig;

        return $object;

    }

    public function getId(): AntwortId {
        return AntwortId::fromString($this->id);
    }

    public function getFragenId(): FragenId {
        return $this->fragenId;
    }

    public function getAntwortCode(): AntwortCode {
        return $this->antwortCode;
    }

    public function istRichtig(): bool {
        return $this->istRichtig;
    }

    public function getAntwortText(): AntwortText {
        return $this->antwortText;
    }

    public function setAntwortText(AntwortText $antwortText): void {
        $this->antwortText = $antwortText;
    }

    public function setIstRichtig(bool $istRichtig): void {
        $this->istRichtig = $istRichtig;
    }

}