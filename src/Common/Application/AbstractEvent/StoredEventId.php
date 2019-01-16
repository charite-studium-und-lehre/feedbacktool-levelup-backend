<?php

namespace Common\Application\AbstractEvent;

use Common\Domain\AggregateId;

/**
 * @static fromInt(int $id) StoredEventId
 */
final class StoredEventId extends AggregateId
{
}