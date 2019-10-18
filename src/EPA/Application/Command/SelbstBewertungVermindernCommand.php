<?php

namespace EPA\Application\Command;

use Common\Application\Command\CommandHandler;
use Common\Application\Command\DomainCommand;
use Common\Application\Command\DomainCommandTrait;
use EPA\Application\Event\SelbstBewertungVermindernEvent;

class SelbstBewertungVermindernCommand extends SelbstBewertungVermindernEvent implements DomainCommand
{
    use DomainCommandTrait;

}