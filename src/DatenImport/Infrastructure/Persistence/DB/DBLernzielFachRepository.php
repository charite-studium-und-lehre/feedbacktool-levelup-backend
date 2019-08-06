<?php

namespace DatenImport\Infrastructure\Persistence\DB;

use Cluster\Domain\ClusterId;
use DatenImport\Domain\LernzielFachRepository;
use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use DatenImport\Domain\LernzielFach;
use DatenImport\Domain\LernzielNummer;

final class DBLernzielFachRepository implements LernzielFachRepository
{
    use DDDDoctrineRepoTrait;

    public function getFachByLernzielNummer(LernzielNummer $lernzielNummer): ?ClusterId {
        $lernzielFach = $this->doctrineRepo->findOneBy(
            ["lernzielNummer" => $lernzielNummer]
        );
        /** @var $lernzielFach LernzielFach */
        return $lernzielFach ? $lernzielFach->getClusterId() : NULL;
    }

    public function addLernzielFach(\DatenImport\Domain\LernzielFach $lernzielFach): void {
        if (!$this->getFachByLernzielNummer($lernzielFach->getLernzielNummer())) {
            $this->entityManager->persist($lernzielFach);
        }
    }

    public function delete(LernzielFach $lernzielFach): void {
        if ($this->getFachByLernzielNummer($lernzielFach->getLernzielNummer())) {
            $this->abstractDelete($lernzielFach);
        }
    }
}