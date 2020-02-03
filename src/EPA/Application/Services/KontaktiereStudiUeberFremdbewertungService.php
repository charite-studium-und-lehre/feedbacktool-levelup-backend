<?php

namespace EPA\Application\Services;

use EPA\Application\Command\StudiUeberFremdbewertungInformierenCommand;

interface KontaktiereStudiUeberFremdbewertungService
{
    public function run(StudiUeberFremdbewertungInformierenCommand $command): void;

}