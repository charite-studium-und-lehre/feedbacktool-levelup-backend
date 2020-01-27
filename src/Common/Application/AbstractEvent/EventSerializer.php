<?php

namespace Common\Application\AbstractEvent;

interface EventSerializer
{
    /** @param Array<String, String> $eventValues */
    public function serializeEventBody(array $eventValues): StoredEventBody;

    /** @return Array<String, String> */
    public function unSerializeEventBody(StoredEventBody $storedEventBody): array;
}