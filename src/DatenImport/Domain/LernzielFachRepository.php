<?php

namespace DatenImport\Domain;

use Cluster\Domain\ClusterId;
use Common\Domain\FlushableRepository;

interface LernzielFachRepository extends FlushableRepository
{
    /** @return LernzielFach[] */
    public function all(): array;

    public function addLernzielFach(LernzielFach $lernzielFach): void;

    public function getFachClusterIdByLernzielNummer(LernzielNummer $lernzielNummer): ?ClusterId;

    public function delete(LernzielFach $lernzielFach): void;
}