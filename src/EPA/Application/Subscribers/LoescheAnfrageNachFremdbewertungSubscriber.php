<?php

namespace EPA\Application\Subscribers;

use Common\Application\Command\CommandBus;
use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventSubscriber;
use Common\Application\DomainEvent\DomainEventSubscriberTrait;
use EPA\Application\Command\FremdBewertungAnfrageLoeschenCommand;
use EPA\Application\Event\FremdBewertungAbgegebenEvent;

class LoescheAnfrageNachFremdbewertungSubscriber implements DomainEventSubscriber
{
    use DomainEventSubscriberTrait;

    private $isSubscribedTo = [FremdBewertungAbgegebenEvent::class];

    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus) {
        $this->commandBus = $commandBus;
    }

    /** @param FremdBewertungAbgegebenEvent $event */
    public function handle(DomainEvent $event): void {
        $command = new FremdBewertungAnfrageLoeschenCommand();
        $command->fremdBewertungsAnfrageId = $event->fremdBewertungsAnfrageId;

        $this->commandBus->execute($command);
    }

}