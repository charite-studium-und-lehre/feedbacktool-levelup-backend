<?php

namespace EPA\Application\Event;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventTrait;

class StudiUeberFremdbewertungInformiertEvent implements DomainEvent
{
    use DomainEventTrait;

    public int $fremdBewertungsId;

    public string $fremdBewerterName;

    public string $fremdBewerterEmail;

    public string $loginHash;

    public string $studiName;

    public string $studiEmail;

}
