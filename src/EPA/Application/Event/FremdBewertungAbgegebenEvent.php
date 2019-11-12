<?php

namespace EPA\Application\Event;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventTrait;

class FremdBewertungAbgegebenEvent implements DomainEvent
{
    use DomainEventTrait;

    /** @var int */
    public $fremdBewertungsId;

    /** @var int */
    public $fremdBewertungsAnfrageId;

    /** @var string */
    public $loginHash;

    /** @var string */
    public $studiEmail;

    /** @var string */
    public $studiName;

    /** @var string */
    public $bewerterName;

    /** @var string */
    public $bewerterEmail;

    /** @var FremdBewertungDTO[] */
    public $fremdBewertungen;
}
