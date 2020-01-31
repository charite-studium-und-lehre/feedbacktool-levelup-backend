<?php

namespace Common\Application\AbstractEvent;

use Common\Application\DomainEvent\DomainEvent;
use DateTimeImmutable;

class StoredEvent implements DomainEvent
{
    use AbstractEventTrait;

    private StoredEventId $id;

    private StoredEventBody $eventBody;

    private StoredEventClass $eventClass;

    public static function fromData(
        StoredEventId $id,
        StoredEventClass $eventClass,
        StoredEventBody $eventBody,
        DateTimeImmutable $occurredOn,
        ?int $byUserId = NULL
    ): self {
        $object = new static();
        $object->id = $id;
        $object->eventClass = $eventClass;
        $object->eventBody = $eventBody;
        $object->occurredOn = $occurredOn;
        $object->byUserId = $byUserId;

        return $object;
    }

    public function getEventBody(): StoredEventBody {
        return $this->eventBody;
    }

    public function getId(): StoredEventId {
        return $this->id;
    }

    public function getEventClass(): StoredEventClass {
        return $this->eventClass;
    }
}
