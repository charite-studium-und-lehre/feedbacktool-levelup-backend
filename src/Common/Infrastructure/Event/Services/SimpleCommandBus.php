<?php

namespace Common\Infrastructure\Event\Services;

use Common\Application\Command\CommandBus;
use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\DomainEvent\DomainEventPublisher;

class SimpleCommandBus implements CommandBus
{
    /** @var CommandHandler[] */
    private $allhandlers;

    /** @var SimpleDomainEventPublisher */
    private $domainEventPublisher;

    /**
     * @var $allHandlers CommandHandler[]
     */
    public function __construct(
        iterable $allHandlers,
        DomainEventPublisher $domainEventPublisher
    ) {

        $allHandlersByCommand = [];
        foreach ($allHandlers as $handler) {
            $allHandlersByCommand[$handler->canHandle()] = $handler;
        }
        $this->allhandlers = $allHandlersByCommand;
        $this->domainEventPublisher = $domainEventPublisher;
    }

    public function execute(DomainCommand $command): void {
        $commandClass = get_class($command);
        if (!array_key_exists($commandClass, $this->allhandlers)) {
            throw new \Exception("Kein Handler gefunden für " .  $commandClass);
        }
        $handler = $this->allhandlers[$commandClass];
        $handler->handle($command);
        $this->publishEvent($command);
    }

    private function publishEvent(DomainCommand $command) {

        $event = call_user_func([get_parent_class($command), 'fromCommand'], $command);
        if ($event instanceof \Exception) {
            throw $event;
        }
        $this->domainEventPublisher->publish($event);
    }
}
