<?php

namespace Studi\Application\Command;

use Common\Application\Command\DomainCommand;
use Common\Application\Command\DomainCommandTrait;
use Studi\Application\Event\StudiInternHinzufuegenEvent;

final class StudiInternHinzufuegenCommand extends StudiInternHinzufuegenEvent implements DomainCommand
{
    use DomainCommandTrait;
}
