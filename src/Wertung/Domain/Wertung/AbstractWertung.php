<?php

namespace Wertung\Domain\Wertung;

abstract class AbstractWertung implements Wertung
{
    /** @var string */
    protected $kommentar;

    public function getKommentar(): string {
        return $this->kommentar;
    }

}