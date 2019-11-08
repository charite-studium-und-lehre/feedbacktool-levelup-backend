<?php

namespace Common\Application\DomainEvent;

interface DomainEventSubscriber
{

    public function handle(DomainEvent $event): void;

    public function isSubscribedTo(DomainEvent $aDomainEvent): bool;

}