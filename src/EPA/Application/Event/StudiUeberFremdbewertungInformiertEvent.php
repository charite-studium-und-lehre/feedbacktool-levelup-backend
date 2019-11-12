<?php

namespace EPA\Application\Event;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventTrait;

class StudiUeberFremdbewertungInformiertEvent implements DomainEvent
{
    use DomainEventTrait;

    /** @var int */
    public $fremdBewertungsId;

    /** @var string */
    public $fremdBewerterName;

    /** @var string */
    public $fremdBewerterEmail;

    /** @var string */
    public $loginHash;

    /** @var string */
    public $studiName;

    /** @var string */
    public $studiEmail;

}
