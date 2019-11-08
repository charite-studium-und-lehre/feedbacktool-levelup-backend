<?php

namespace EPA\Application\Command;

use Common\Application\Command\CommandHandler;
use Common\Application\Command\DomainCommand;
use Common\Application\Command\DomainCommandTrait;
use EPA\Application\Event\FremdBewertungAbgegebenEvent;
use EPA\Application\Event\FremdBewertungAngefragtEvent;

class FremdBewertungAbgebenCommand extends FremdBewertungAbgegebenEvent implements DomainCommand
{
    use DomainCommandTrait;

}
