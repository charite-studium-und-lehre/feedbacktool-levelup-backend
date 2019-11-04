<?php

namespace EPA\Application\Subscribers;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventSubscriber;
use EPA\Application\Event\FremdBewertungAnfragenEvent;
use EPA\Application\Services\KontaktiereFremdBewerterService;

class VersendeMailNachFremdBewertungsAnfrageSubscriber implements DomainEventSubscriber
{
    /** @var KontaktiereFremdBewerterService */
    private $kontaktiereFremdBewerterService;

    public function __construct(KontaktiereFremdBewerterService $kontaktiereFremdBewerterService) {
        $this->kontaktiereFremdBewerterService = $kontaktiereFremdBewerterService;
    }

    /** @param $aDomainEvent FremdBewertungAnfragenEvent */
    public function handle(DomainEvent $aDomainEvent): void {
        $this->kontaktiereFremdBewerterService->run($aDomainEvent);
    }

    public function isSubscribedTo(DomainEvent $aDomainEvent): bool {
        return $aDomainEvent instanceof FremdBewertungAnfragenEvent;
    }
}