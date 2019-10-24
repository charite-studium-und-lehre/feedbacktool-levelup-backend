<?php

namespace Wertung\Domain\Wertung;

use Common\Domain\DDDValueObject;
use Wertung\Domain\Skala\Skala;

interface Wertung extends DDDValueObject
{
    public function getRelativeWertung(): float;

    public function getSkala(): Skala;

    public function istPunktWertung(): bool;

    public function getPunktWertung(): PunktWertung;

    public function istProzentWertung(): bool;

    public function getProzentWertung(): ProzentWertung;

    public function istRichtigFalschWeissnichtWertung(): bool;

    public function getRichtigFalschWeissnichtWertung(): RichtigFalschWeissnichtWertung;

    public static function getDurchschnittsWertung(array $wertungen);

    public static function getSummenWertung(array $wertungen);

}