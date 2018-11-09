<?php

namespace Common\Application\DomainEvent;

interface DomainEventSubscriber
{

    public function handle(DomainEvent $aDomainEvent);

    public function isSubscribedTo(DomainEvent $aDomainEvent): bool;

}