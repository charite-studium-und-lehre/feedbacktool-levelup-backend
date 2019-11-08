<?php

namespace EPA\Application\Event;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventTrait;

class SelbstBewertungGeandertEvent implements DomainEvent
{
    use DomainEventTrait;

    /** @var string */
    public $loginHash;

    /** @var int */
    public $epaId;

    /** @var int */
    public $zutrauen;

    /** @var int */
    public $gemacht;
}