<?php

namespace EPA\Application\Subscribers;

use Common\Application\Command\CommandBus;
use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventSubscriber;
use Common\Application\DomainEvent\DomainEventSubscriberTrait;
use EPA\Application\Command\StudiUeberFremdbewertungInformierenCommand;
use EPA\Application\Event\FremdBewertungAbgegebenEvent;

class KontaktiereStudiNachFremdbewertungSubscriber implements DomainEventSubscriber
{
    use DomainEventSubscriberTrait;

    /** @var string[] */
    private array $isSubscribedTo = [FremdBewertungAbgegebenEvent::class];

    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus) {
        $this->commandBus = $commandBus;
    }

    /** @param FremdBewertungAbgegebenEvent $event */
    public function handle(DomainEvent $event): void {
        $command = new StudiUeberFremdbewertungInformierenCommand();
        $command->fremdBewertungsId = $event->fremdBewertungsId;
        $command->fremdBewerterName = $event->bewerterName;
        $command->fremdBewerterEmail = $event->bewerterEmail;
        $command->studiEmail = $event->studiEmail;
        $command->studiName = $event->studiName;

        $this->commandBus->execute($command);
    }

}