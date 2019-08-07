<?php

namespace DatenImport\Domain;

interface LernzielFachDatenEinleseService
{
    /** @return array<int LernzielNummer, string FachCode */
    public function getData(): array;
}