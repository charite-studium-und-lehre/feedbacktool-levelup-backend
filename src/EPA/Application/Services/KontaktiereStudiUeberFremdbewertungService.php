<?php

namespace EPA\Application\Services;

use EPA\Application\Command\FremdBewertungAnfrageVerschickenCommand;

interface KontaktiereStudiUeberFremdbewertungService
{
    public function run(FremdBewertungAnfrageVerschickenCommand $command): void;

}