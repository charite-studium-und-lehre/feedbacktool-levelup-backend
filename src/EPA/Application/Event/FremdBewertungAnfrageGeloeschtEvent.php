<?php

namespace EPA\Application\Event;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventTrait;

class FremdBewertungAnfrageGeloeschtEvent implements DomainEvent
{
    use DomainEventTrait;

    public int $fremdBewertungsAnfrageId;
}
