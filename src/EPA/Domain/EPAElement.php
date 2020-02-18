<?php

namespace EPA\Domain;

interface EPAElement
{
    public function istBlatt(): bool;

    public function getNummer(): int;

    public function getBeschreibung(): string;

    public function getParent(): ?EPAKategorie;
}