<?php

namespace EPA\Application\Subscribers;

use Common\Application\Command\CommandBus;
use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventSubscriber;
use Common\Application\DomainEvent\DomainEventSubscriberTrait;
use EPA\Application\Command\FremdBewertungAnfrageVerschickenCommand;
use EPA\Application\Event\FremdBewertungAngefragtEvent;

class VersendeMailNachFremdBewertungsAnfrageSubscriber implements DomainEventSubscriber
{

    use DomainEventSubscriberTrait;

    private $isSubscribedTo = [FremdBewertungAngefragtEvent::class];

    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus) {
        $this->commandBus = $commandBus;
    }

    /** @param $event FremdBewertungAngefragtEvent */
    public function handle(DomainEvent $event): void {
        $command = new FremdBewertungAnfrageVerschickenCommand();

        $command->fremdBewertungsAnfrageId = $event->fremdBewertungsAnfrageId;
        $command->loginHash = $event->loginHash;
        $command->fremdBewerterName = $event->fremdBewerterName;
        $command->fremdBewerterEmail = $event->fremdBewerterEmail;
        $command->studiEmail = $event->studiEmail;
        $command->studiName = $event->studiName;
        $command->angefragteTaetigkeiten = $event->angefragteTaetigkeiten;
        $command->kommentar = $event->kommentar;

        $this->commandBus->execute($command);
    }

}