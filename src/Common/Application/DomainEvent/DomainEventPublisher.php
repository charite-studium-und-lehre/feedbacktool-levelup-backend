<?php

namespace Common\Application\DomainEvent;

interface DomainEventPublisher
{
    public function subscribe(DomainEventSubscriber $domainEventSubscriber);

    public function publish(DomainEvent $domainEvent);

}