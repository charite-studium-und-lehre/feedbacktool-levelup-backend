<?php

namespace Common\Infrastructure\Event\Services;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventPublisher;
use Common\Application\DomainEvent\DomainEventSubscriber;
use Common\Domain\Services\CurrentUserIdService;

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

        foreach ($domainEventSubscribers as $domainEventSubscriber) {
            $this->subscribe($domainEventSubscriber);
        }

    }

    public function subscribe(DomainEventSubscriber $domainEventSubscriber): void {
        $this->subscribers[] = $domainEventSubscriber;
    }

    public function publish(DomainEvent $domainEvent): void {
        $domainEvent->setInitialValues($this->currentUserIdService->getUserId());

        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($domainEvent)) {
                $subscriber->handle($domainEvent);
            }
        }
    }

}