<?php

namespace EPA\Application\Command;

use Common\Application\Command\CommandHandler;
use Common\Application\Command\DomainCommand;
use Common\Application\Command\DomainCommandTrait;
use EPA\Application\Event\FremdBewertungAngefragtEvent;

class FremdBewertungAnfragenCommand extends FremdBewertungAngefragtEvent implements DomainCommand
{
    use DomainCommandTrait;
}
