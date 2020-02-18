<?php

namespace Common\Application\AbstractEvent;

use Common\Application\DomainEvent\DomainEvent;
use ReflectionObject;

class EventPersister
{
    private EventSerializer $eventSerializer;

    private StoredEventRepository $storedEventRepository;

    public function __construct(EventSerializer $eventSerializer, StoredEventRepository $storedEventRepository) {
        $this->eventSerializer = $eventSerializer;
        $this->storedEventRepository = $storedEventRepository;
    }

    public function createStoredEvent(DomainEvent $domainEvent): StoredEvent {
        $storedEventId = $this->storedEventRepository->nextIdentity();
        $storedEventClass = StoredEventClass::fromString(get_class($domainEvent));
        $eventValuesDict = $this->createEventValuesDict($domainEvent);
        $storedEventBody = $this->eventSerializer->serializeEventBody($eventValuesDict);

        return StoredEvent::fromData(
            $storedEventId,
            $storedEventClass,
            $storedEventBody,
            $domainEvent->getOccurredOn(),
            $domainEvent->getByUserId()
        );
    }

    public function recoverDomainEvent(StoredEvent $storedEvent): DomainEvent {
        $domainEventClass = $storedEvent->getEventClass()->getValue();
        /** @var DomainEvent $domainEvent */
        $domainEvent = new $domainEventClass();
        $domainEvent->byUserId = $storedEvent->getByUserId();
        $domainEvent->occurredOn = $storedEvent->getOccurredOn();

        foreach ($this->eventSerializer->unSerializeEventBody($storedEvent->getEventBody())
            as $key => $value) {
            $domainEvent->$key = $value;
        }

        return $domainEvent;
    }

    /** @return Array<String, String> */
    private function createEventValuesDict(DomainEvent $domainEvent): array {
        $valuesDict = [];
        foreach ((new ReflectionObject($domainEvent))->getProperties() as $property) {
            if (strpos($property->getName(), "_") === 0) {
                continue;
            }
            $valuesDict[$property->getName()] = $property->getValue($domainEvent);
        }

        unset ($valuesDict["occurredOn"]);
        unset ($valuesDict["byUserId"]);

        return $valuesDict;
    }
}