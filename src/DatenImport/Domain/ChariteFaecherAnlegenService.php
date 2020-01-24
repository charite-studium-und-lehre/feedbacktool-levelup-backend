<?php

namespace DatenImport\Domain;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterCode;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTitel;
use Cluster\Domain\ClusterTyp;
use Pruefung\Domain\FachCodeKonstanten;

class ChariteFaecherAnlegenService
{
    private \Cluster\Domain\ClusterRepository $clusterRepository;

    public function __construct(ClusterRepository $clusterRepository) {
        $this->clusterRepository = $clusterRepository;
    }

    public function addAlleFaecherZuDB() {
        foreach (FachCodeKonstanten::FACH_CODES as $fachCode => $fachTitel) {
            $clusterCode = ClusterCode::fromString($fachCode);
            $cluster = $this->clusterRepository->byClusterTypUndCode(ClusterTyp::getFachTyp(), $clusterCode);

            $clusterTitelNeu = ClusterTitel::fromString($fachTitel);
            if ($cluster && !$cluster->getTitel()->equals($clusterTitelNeu)) {
                $cluster->setTitel($clusterTitelNeu);
            }

            if (!$cluster) {
                $cluster = Cluster::create(
                    $this->clusterRepository->nextIdentity(),
                    ClusterTyp::getFachTyp(),
                    $clusterTitelNeu,
                    NULL,
                    $clusterCode,
                    );
                $this->clusterRepository->add($cluster);;
            }
        }

        $this->clusterRepository->flush();
    }

}