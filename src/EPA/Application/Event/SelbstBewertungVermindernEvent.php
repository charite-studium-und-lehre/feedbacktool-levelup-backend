<?php

namespace EPA\Application\Event;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventTrait;

class SelbstBewertungVermindernEvent implements DomainEvent
{
    use DomainEventTrait;

    /** @var string */
    public $studiHash;

    /** @var int */
    public $selbstBewertungsTyp;

    /** @var int */
    public $epaId;
}