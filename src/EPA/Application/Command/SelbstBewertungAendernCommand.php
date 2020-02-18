<?php

namespace EPA\Application\Command;

use Common\Application\Command\CommandHandler;
use Common\Application\Command\DomainCommand;
use Common\Application\Command\DomainCommandTrait;
use EPA\Application\Event\SelbstBewertungGeandertEvent;

class SelbstBewertungAendernCommand extends SelbstBewertungGeandertEvent implements DomainCommand
{
    use DomainCommandTrait;
}
