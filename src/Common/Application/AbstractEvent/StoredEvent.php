<?php

namespace Common\Application\AbstractEvent;

use Common\Application\DomainEvent\DomainEvent;
use DateTimeImmutable;

class StoredEvent implements DomainEvent
{
    use AbstractEventTrait;

    /** @var StoredEventId */
    private $id;

    /** @var StoredEventBody */
    private $eventBody;

    /** @var StoredEventClass */
    private $eventClass;

    public static function fromData(
        StoredEventId $id,
        StoredEventClass $eventClass,
        StoredEventBody $eventBody,
        DateTimeImmutable $occurredOn,
        ?int $byUserId = NULL
    ) {
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
