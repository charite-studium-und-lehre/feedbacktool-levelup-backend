<?php

namespace EPA\Application\Event;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventTrait;

class SelbstBewertungErhoehenEvent implements DomainEvent
{
    use DomainEventTrait;

    /** @var string */
    public $loginHash;

    /** @var int */
    public $selbstBewertungsTyp;

    /** @var int */
    public $epaId;
}