<?php

namespace Wertung\Domain\Wertung;

abstract class AbstractWertung implements WertungsInterface
{
    /** @var string */
    protected $kommentar;

    public function getKommentar(): string {
        return $this->kommentar;
    }

}