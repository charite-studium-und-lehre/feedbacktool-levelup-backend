<?php

namespace Common\Application\AbstractEvent;

interface EventSerializer
{
    public function serializeEventBody(array $eventValues): StoredEventBody;

    public function unSerializeEventBody(StoredEventBody $storedEventBody): array;
}