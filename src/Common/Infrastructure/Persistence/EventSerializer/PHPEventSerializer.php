<?php

namespace Common\Infrastructure\Persistence\EventSerializer;

use Common\Application\AbstractEvent\EventSerializer;
use Common\Application\AbstractEvent\StoredEventBody;
use Exception;

final class PHPEventSerializer implements EventSerializer
{

    public function serializeEventBody(array $eventValues): StoredEventBody {
        return StoredEventBody::fromString(
            serialize($eventValues)
        );
    }

    public function unSerializeEventBody(StoredEventBody $storedEventBody): array {
        $unserializedArray = unserialize(
            $storedEventBody->getValue(),
            ["allowed_classes" => FALSE]
        );

        if (!is_array($unserializedArray)) {
            throw new Exception("unserialized event body must be array!");
        }

        foreach ($unserializedArray as $key => $value) {
            if (!is_scalar($value) && !empty($value)) {
                throw new Exception("unserialized event body array must have only scalar values!");
            }
        }

        return $unserializedArray;
    }
}