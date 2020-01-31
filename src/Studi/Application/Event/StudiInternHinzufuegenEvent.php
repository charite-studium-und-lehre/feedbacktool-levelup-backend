<?php

namespace Studi\Application\Event;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventTrait;

class StudiInternHinzufuegenEvent implements DomainEvent
{
    use DomainEventTrait;

    public string $studiHash;

    public string $matrikelnummer;

}
