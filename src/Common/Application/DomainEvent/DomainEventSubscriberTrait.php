<?php

namespace Common\Application\DomainEvent;

trait DomainEventSubscriberTrait
{

    public function isSubscribedTo(DomainEvent $aDomainEvent): bool {
        return in_array(get_class($aDomainEvent), $this->isSubscribedTo);
    }

}