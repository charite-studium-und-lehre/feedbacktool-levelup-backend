<?php

namespace Common\Application\AbstractEvent;

use DateTimeImmutable;

interface AbstractEvent
{
    public function getOccurredOn(): DateTimeImmutable;

    public function getByUserId(): int;

    public function setInitialValues(?int $byUserId): void;
}