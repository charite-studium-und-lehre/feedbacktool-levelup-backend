<?php

namespace Common\Application\CommandHandler;

use Common\Application\DomainEvent\DomainEvent;

trait CommandHandlerTrait
{
    public function canHandle(): string {
        return preg_replace("/Handler$/", "Command", get_class($this));
    }

    /** @return DomainEvent[] */
    public function getAdditionalFiredEvents(): array {
        if (!empty($this->additionalFiredEvents)) {
            return $this->additionalFiredEvents;
        }

        return [];
    }
}