<?php

namespace EPA\Application\Event;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventTrait;

class FremdBewertungAnfragenEvent implements DomainEvent
{
    use DomainEventTrait;

    /** @var int */
    public $fremdBewertungsAnfrageId;

    /** @var string */
    public $fremdBewerterName;

    /** @var string */
    public $fremdBewerterEmail;

    /** @var string */
    public $angefragteTaetigkeiten;

    /** @var string */
    public $kommentar;

    /** @var string */
    public $loginHash;

    /** @var string */
    public $studiName;

    /** @var string */
    public $studiEmail;
}
