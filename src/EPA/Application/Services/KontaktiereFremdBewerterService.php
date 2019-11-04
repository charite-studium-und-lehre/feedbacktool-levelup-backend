<?php

namespace EPA\Application\Services;

use EPA\Application\Event\FremdBewertungAnfragenEvent;

interface KontaktiereFremdBewerterService
{
    public function run(FremdBewertungAnfragenEvent $event): void;

}