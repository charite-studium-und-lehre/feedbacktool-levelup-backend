<?php

namespace EPA\Application\Services;

use EPA\Application\Command\FremdBewertungAnfrageVerschickenCommand;

interface KontaktiereFremdBewerterService
{
    public function run(FremdBewertungAnfrageVerschickenCommand $command): void;

}