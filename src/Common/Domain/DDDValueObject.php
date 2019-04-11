<?php

namespace Common\Domain;

interface DDDValueObject
{
    public function equals(object $otherObject): bool;
}