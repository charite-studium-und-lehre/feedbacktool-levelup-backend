<?php

namespace Wertung\Domain\Wertung;

use Common\Domain\DDDValueObject;
use Wertung\Domain\Skala\Skala;

interface Wertung extends DDDValueObject
{
    /**
     * @param Wertung[] $wertungen
     * @return Wertung
     */
    public static function getDurchschnittsWertung(array $wertungen);

    /**
     * @param Wertung[] $wertungen
     * @return Wertung
     */
    public static function getSummenWertung(array $wertungen);

    public function getRelativeWertung(): float;

    public function getSkala(): Skala;

    public function getPunktWertung(): ?PunktWertung;

    public function getProzentWertung(): ?ProzentWertung;

    public function getRichtigFalschWeissnichtWertung(): ?RichtigFalschWeissnichtWertung;

}