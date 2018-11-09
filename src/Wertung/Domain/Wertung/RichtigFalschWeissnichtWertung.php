<?php

namespace Wertung\Domain\Wertung;

use Assert\Assertion;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Skala\Skala;

class RichtigFalschWeissnichtWertung extends PunktWertung
{

    /** @var bool */
    private $weissNicht;

    public static function fromPunkteUndWeissnicht(
        Punktzahl $punktzahl,
        PunktSkala $skala,
        bool $weissnicht,
        string $kommentar = NULL
    ):
    PunktWertung {
        Assertion::boolean($weissnicht);

        $object = static::fromPunktzahlUndSkala($punktzahl, $skala, $kommentar);
        /* @var $object RichtigFalschWeissnichtWertung */
        $object->weissNicht = $weissnicht;

        return $object;
    }

    /** @return bool */
    public function isWeissNicht(): bool {
        return $this->weissNicht;
    }

}