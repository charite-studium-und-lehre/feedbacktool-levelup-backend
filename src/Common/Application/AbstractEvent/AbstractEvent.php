<?php

namespace Common\Application\AbstractEvent;

interface AbstractEvent
{
    public function getOccurredOn(): \DateTimeImmutable;
    public function getByUserId(): int;
    public function setInitialValues(?int $byUserId) : void;
}