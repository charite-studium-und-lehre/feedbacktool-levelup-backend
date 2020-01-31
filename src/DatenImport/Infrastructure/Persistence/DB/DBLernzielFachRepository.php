<?php

namespace DatenImport\Infrastructure\Persistence\DB;

use Cluster\Domain\ClusterId;
use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use DatenImport\Domain\LernzielFach;
use DatenImport\Domain\LernzielFachRepository;
use DatenImport\Domain\LernzielNummer;

final class DBLernzielFachRepository implements LernzielFachRepository
{
    use DDDDoctrineRepoTrait;

    public function getFachClusterIdByLernzielNummer(LernzielNummer $lernzielNummer): ?ClusterId {
        /** @var ?LernzielFach $lernzielFach */
        $lernzielFach = $this->doctrineRepo->findOneBy(
            ["lernzielNummer" => $lernzielNummer]
        );

        return $lernzielFach ? $lernzielFach->getClusterId() : NULL;
    }

    public function addLernzielFach(LernzielFach $lernzielFach): void {
        if (!$this->getFachClusterIdByLernzielNummer($lernzielFach->getLernzielNummer())) {
            $this->entityManager->persist($lernzielFach);
        }
    }

    public function delete(LernzielFach $lernzielFach): void {
        if ($this->getFachClusterIdByLernzielNummer($lernzielFach->getLernzielNummer())) {
            $this->abstractDelete($lernzielFach);
        }
    }
}