<?php

namespace Common\Domain;

interface DDDEntity
{
    public function equals(object $otherObject): bool;
}