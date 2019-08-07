<?php

namespace DatenImport\Infrastructure\Persistence\Filesystem;

use Cluster\Domain\ClusterId;
use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use DatenImport\Domain\LernzielFach;
use DatenImport\Domain\LernzielFachRepository;
use DatenImport\Domain\LernzielNummer;

final class FileBasedSimpleLernzielFachRepository extends AbstractCommonRepository implements LernzielFachRepository
{
    use FileBasedRepoTrait;

    public function getFachClusterIdByLernzielNummer(LernzielNummer $lernzielNummer): ?ClusterId {
        foreach ($this->all() as $lernzielFach) {
            /** @var $lernzielFach LernzielFach */
            if ($lernzielFach->getLernzielNummer()->equals($lernzielNummer)) {
                return $lernzielFach->getClusterId();
            }
        }

        return NULL;
    }

    public function addLernzielFach(LernzielFach $lernzielFach): void {
        if (!$this->getFachClusterIdByLernzielNummer($lernzielFach->getLernzielNummer())) {
            $this->add($lernzielFach);
        }
    }

    public function delete($lernzielFach): void {
        if ($this->getFachClusterIdByLernzielNummer($lernzielFach->getLernzielNummer())) {
            parent::delete($lernzielFach);
        }
    }
}
