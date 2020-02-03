<?php

namespace Common\Application\CommandHandler;

use Common\Application\Command\DomainCommand;
use Common\Application\DomainEvent\DomainEvent;

interface CommandHandler
{
    /** return the command class name this handler can handle */
    public function canHandle(): string;

    public function handle(DomainCommand $command): void;

    /** @return DomainEvent[] */
    public function getAdditionalFiredEvents(): array;
}