<?php

namespace Pruefung\Domain\FrageAntwort;

use Common\Domain\DDDEntity;
use Common\Domain\DefaultEntityComparison;

final class Antwort implements DDDEntity
{
    use DefaultEntityComparison;

    /** @var AntwortId */
    private $id;

    /** @var FragenId */
    private $fragenId;

    /** @var AntwortCode */
    private $antwortCode;

    /** @var AntwortText */
    private $antwortText;

    /** @var bool */
    private $istRichtig;


    public static function fromPruefungsItemIdUndFragenId(
        AntwortId $antwortId,
        FragenId $fragenId,
        AntwortCode $antwortCode,
        AntwortText $antwortText,
        bool $istRichtig
    ) {
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