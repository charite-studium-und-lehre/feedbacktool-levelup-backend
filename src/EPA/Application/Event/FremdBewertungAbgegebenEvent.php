<?php

namespace EPA\Application\Event;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventTrait;

class FremdBewertungAbgegebenEvent implements DomainEvent
{
    use DomainEventTrait;

    /** @var int */
    public $fremdBewertungsId;

    /** @var string */
    public $loginHash;

    /** @var int */
    public $fremdBewertungsAnfrageId;

    /** @var FremdBewertungDTO[] */
    public $fremdBewertungen;
}
