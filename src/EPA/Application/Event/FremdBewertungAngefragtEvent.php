<?php

namespace EPA\Application\Event;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventTrait;

class FremdBewertungAngefragtEvent implements DomainEvent
{
    use DomainEventTrait;

    public int $fremdBewertungsAnfrageId;

    public string $fremdBewerterName;

    public string $fremdBewerterEmail;

    public ?string $angefragteTaetigkeiten;

    public ?string $kommentar;

    public string $loginHash;

    public string $studiName;

    public string $studiEmail;
}
