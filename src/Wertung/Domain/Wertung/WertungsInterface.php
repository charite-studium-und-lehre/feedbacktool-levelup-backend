<?php

namespace Wertung\Domain\Wertung;

use Wertung\Domain\Skala\Skala;

interface WertungsInterface
{
    public function getKommentar(): string;
    public function getRelativeWertung(): float;
    public function getSkala(): Skala;
}