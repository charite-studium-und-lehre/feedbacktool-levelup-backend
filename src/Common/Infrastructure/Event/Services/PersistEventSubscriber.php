<?php

namespace Common\Infrastructure\Event\Services;

use Common\Application\AbstractEvent\EventPersister;
use Common\Application\AbstractEvent\StoredEventRepository;
use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventSubscriber;

class PersistEventSubscriber implements DomainEventSubscriber
{
    /** @var EventPersister */
    private $eventPersister;

    /** @var StoredEventRepository */
    private $storedEventRepository;

    public function __construct(
        EventPersister $eventPersister,
        StoredEventRepository $storedEventRepository
    ) {
        $this->eventPersister = $eventPersister;
        $this->storedEventRepository = $storedEventRepository;
    }

    public function handle(DomainEvent $domainEvent) {
        $storedEvent = $this->eventPersister->createStoredEvent($domainEvent);
        $this->storedEventRepository->add($storedEvent);
        $this->storedEventRepository->flush();
    }

    public function isSubscribedTo(DomainEvent $domainEvent): bool {
        // Interessiert sich für alle Events.
        return true;
    }
}