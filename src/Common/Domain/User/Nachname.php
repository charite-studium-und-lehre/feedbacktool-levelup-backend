<?php

namespace Common\Domain\User;

use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

class Nachname implements DDDValueObject
{
    use DefaultValueObjectComparison;
    use NameTrait;

    const MIN_LENGTH = 2;
    const MAX_LENGTH = 35;

    const UNGUELTIG = "Der Nachname ist ungültig: ";
    const UNGUELTIG_ZU_KURZ = "Der Nachname ist zu kurz: ";
    const UNGUELTIG_ZU_LANG = "Der Nachname ist zu lang: ";

    private string $value;

}