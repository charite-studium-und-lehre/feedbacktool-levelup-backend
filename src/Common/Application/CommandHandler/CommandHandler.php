<?php

namespace Common\Application\CommandHandler;

use Common\Application\Command\DomainCommand;

interface CommandHandler
{
    /** return the command class name this handler can handle */
    public function canHandle(): string;
    public function handle(DomainCommand $command): void;
}