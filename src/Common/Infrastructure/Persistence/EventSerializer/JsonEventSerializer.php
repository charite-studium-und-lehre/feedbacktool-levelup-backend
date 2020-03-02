<?php

namespace Common\Infrastructure\Persistence\EventSerializer;

use Common\Application\AbstractEvent\EventSerializer;
use Common\Application\AbstractEvent\StoredEventBody;
use Exception;

final class JsonEventSerializer implements EventSerializer
{

    public function serializeEventBody(array $eventValues): StoredEventBody {
        return StoredEventBody::fromString(
            json_encode($eventValues)
        );
    }

    public function unSerializeEventBody(StoredEventBody $storedEventBody): array {
        $unserializedArray = json_decode(
            $storedEventBody->getValue(),
            TRUE
        );

        if (!is_array($unserializedArray)) {
            throw new Exception("unserialized event body must be array!");
        }

        foreach ($unserializedArray as $value) {
            if (!is_scalar($value) && !empty($value)) {
                throw new Exception("unserialized event body array must have only scalar values!");
            }
        }

        return $unserializedArray;
    }
}