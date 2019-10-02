<?php

namespace Studi\Domain;

use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;

final class Vorname implements DDDValueObject
{
    use DefaultValueObjectComparison;

    const MIN_LENGTH = 2;
    const MAX_LENGTH = 30;

    const UNGUELTIG = "Der Vorname ist ungültig: ";
    const UNGUELTIG_ZU_KURZ = "Der Vorname ist zu kurz: ";
    const UNGUELTIG_ZU_LANG = "Der Vorname ist zu lang: ";

    private $value;

    use NameTrait;

}