<?php

namespace Common\Application\DomainEvent;

interface DomainEventPublisher
{
    public function subscribe(DomainEventSubscriber $domainEventSubscriber): void;

    public function publish(DomainEvent $domainEvent): void;

}