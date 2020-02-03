<?php

namespace EPA\Application\Event;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventTrait;

class SelbstBewertungGeandertEvent implements DomainEvent
{
    use DomainEventTrait;

    public string $loginHash;

    public int $epaId;

    public int $zutrauen;

    public int $gemacht;
}