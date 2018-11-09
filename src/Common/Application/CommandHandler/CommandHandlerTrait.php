<?php

namespace Common\Application\CommandHandler;

trait CommandHandlerTrait
{
    public function canHandle(): string {
        if (defined('static::CAN_HANDLE')) {
            return static::CAN_HANDLE;
        }

        return preg_replace("/Handler$/", "Command", get_class($this));
    }
}