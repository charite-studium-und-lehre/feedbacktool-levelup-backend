<?php

namespace Common\Application\Command;

interface CommandBus
{
    public function execute(DomainCommand $command) : void;
}