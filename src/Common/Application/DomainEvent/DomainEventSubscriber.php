<?php

namespace Common\Application\DomainEvent;

interface DomainEventSubscriber
{

    public function handle(DomainEvent $aDomainEvent): void;

    public function isSubscribedTo(DomainEvent $aDomainEvent): bool;

}