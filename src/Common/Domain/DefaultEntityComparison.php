<?php

namespace Common\Domain;

trait DefaultEntityComparison
{
    /**
     * Standardmäßig ist Gleichheit: Objekt-Referenz ist gleich
     *
     * @param object $otherObject
     * @return bool
     */
    public function equals(object $otherObject): bool {
        return $this === $otherObject;
    }
}