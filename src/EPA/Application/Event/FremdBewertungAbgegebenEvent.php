<?php

namespace EPA\Application\Event;

use Common\Application\DomainEvent\DomainEvent;
use Common\Application\DomainEvent\DomainEventTrait;

class FremdBewertungAbgegebenEvent implements DomainEvent
{
    use DomainEventTrait;

    public int $fremdBewertungsId;

    public int $fremdBewertungsAnfrageId;

    public string $loginHash;

    public string $studiEmail;

    public string $studiName;

    public string $bewerterName;

    public string $bewerterEmail;

    /**
     * @var array<array<string, int>>
     * @see FremdBewertungDTO
     */
    public array $fremdBewertungen;
}
