<?php

namespace Common\Infrastructure\Event\Services;

use Common\Application\CurrentUserIdService;
use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventPublisher;
use Common\Application\DomainEvent\DomainEventSubscriber;

class SimpleDomainEventPublisher implements DomainEventPublisher
{

    /** @var DomainEventSubscriber[] */
    private $subscribers = [];

    /** @var CurrentUserIdService */
    private $currentUserIdService;

    /**
     * @param DomainEventSubscriber[] $domainEventSubscribers
     */
    public function __construct(iterable $domainEventSubscribers, CurrentUserIdService $currentUserIdService) {
        $this->currentUserIdService = $currentUserIdService;

        foreach (iterator_to_array($domainEventSubscribers) as $domainEventSubscriber) {
            $this->subscribe($domainEventSubscriber);
        }

    }

    public function subscribe(DomainEventSubscriber $domainEventSubscriber) {
        $this->subscribers[] = $domainEventSubscriber;
    }

    public function publish(DomainEvent $domainEvent) {
        $domainEvent->setInitialValues($this->currentUserIdService->getUserId());

        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($domainEvent)) {
                $subscriber->handle($domainEvent);
            }
        }
    }

}