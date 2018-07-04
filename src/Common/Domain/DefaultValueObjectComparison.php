<?php

namespace Common\Domain;

trait DefaultValueObjectComparison
{
    /**
     * Standardmäßig ist Gleichheit: Gleiche Klasse und gleiche Objektvariablen
     * -> PHP "=="
     * http://php.net/manual/de/language.oop5.object-comparison.php
     *
     * @param object $otherObject
     * @return bool
     */
    public function equals(object $otherObject): bool {
        return $this == $otherObject;
    }
}