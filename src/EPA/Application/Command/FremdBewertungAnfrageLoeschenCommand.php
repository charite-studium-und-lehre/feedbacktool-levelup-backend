<?php

namespace EPA\Application\Command;

use Common\Application\Command\CommandHandler;
use Common\Application\Command\DomainCommand;
use Common\Application\Command\DomainCommandTrait;
use EPA\Application\Event\FremdBewertungAnfrageGeloeschtEvent;
use EPA\Application\Event\FremdBewertungAngefragtEvent;

class FremdBewertungAnfrageLoeschenCommand extends FremdBewertungAnfrageGeloeschtEvent implements DomainCommand
{
    use DomainCommandTrait;

}
