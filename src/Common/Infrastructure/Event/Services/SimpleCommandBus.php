<?php

namespace Common\Infrastructure\Event\Services;

use Common\Application\Command\CommandBus;
use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventPublisher;
use Exception;

class SimpleCommandBus implements CommandBus
{
    /** @var CommandHandler[] */
    private $allhandlers;

    /** @var DomainEventPublisher */
    private $domainEventPublisher;

    /**
     * @param CommandHandler[] $allHandlers
     */
    public function __construct(iterable $allHandlers) {

        $allHandlersByCommand = [];
        foreach ($allHandlers as $handler) {
            $allHandlersByCommand[$handler->canHandle()] = $handler;
        }
        $this->allhandlers = $allHandlersByCommand;
    }

    /**
     * Der DomainEventPublisher kann nicht im Konstruktur ünbergeben werden, weil es dann
     * eine zirkuläre Abhängigket mit ihm git. Deshalb wird er nachträglich übergeben.
     */
    public function setDomainEventPublisher(DomainEventPublisher $domainEventPublisher): void {
        $this->domainEventPublisher = $domainEventPublisher;
    }

    public function execute(DomainCommand $command): void {
        $commandClass = get_class($command);
        if (!array_key_exists($commandClass, $this->allhandlers)) {
            throw new Exception("Kein Handler gefunden für " . $commandClass);
        }
        $handler = $this->allhandlers[$commandClass];
        $handler->handle($command);
        $this->publishEventFromCommand($command);

        foreach ($handler->getAdditionalFiredEvents() as $additionalEvent) {
            $this->publishEvent($additionalEvent);
        }
    }

    private function publishEventFromCommand(DomainCommand $command): void {
        $event = call_user_func([get_parent_class($command), 'fromCommand'], $command);
        if ($event instanceof Exception) {
            throw $event;
        }
        $this->publishEvent($event);
    }

    private function publishEvent(DomainEvent $event): void {
        $this->domainEventPublisher->publish($event);
    }
}
