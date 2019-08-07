<?php

namespace DatenImport\Domain;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTyp;

class ChariteLernzielFachPersistenzService
{
    /** @var LernzielFachRepository */
    private $lernzielFachRepository;

    /** @var ClusterRepository */
    private $clusterRepository;

    public function __construct(LernzielFachRepository $lernzielFachRepository, ClusterRepository $clusterRepository) {
        $this->lernzielFachRepository = $lernzielFachRepository;
        $this->clusterRepository = $clusterRepository;
    }

    /** @param array<int $lernzielNummer => string $fachCode */
    public function persistiereLernzielFaecher(array $lernzielFaecher) {

        $alleFaecherNachCode = $this->alleFaecherNachCode();
        $alleLernzielFaecherNachLernzielNummer = $this->allerLernzielFaecherNachLernzielNummer();

        foreach ($lernzielFaecher as $lernzielNummer => $fachCode) {
            $fachCode = trim($fachCode);
            if (!array_key_exists($fachCode, $alleFaecherNachCode)) {
                echo "Import-Warnung: Fach ist in DB nicht vorhanden: '$fachCode'\n";
                continue;
            }
            $fachIstCluster = $alleFaecherNachCode[$fachCode];

            $existierendesLernzielFach = isset($alleLernzielFaecherNachLernzielNummer[$lernzielNummer])
                ? $alleLernzielFaecherNachLernzielNummer[$lernzielNummer] : NULL;
            if ($existierendesLernzielFach) {
                if ($existierendesLernzielFach->getClusterId()->equals($alleFaecherNachCode[$fachCode])) {
                    continue;
                }
                $this->lernzielFachRepository->delete($existierendesLernzielFach);
            }

            $neuesLernztielFach = LernzielFach::byIds(
                LernzielNummer::fromInt($lernzielNummer),
                $fachIstCluster->getId()
            );
            $this->lernzielFachRepository->addLernzielFach($neuesLernztielFach);
        }
        $this->lernzielFachRepository->flush();
    }

    /** @return Cluster[] */
    private function alleFaecherNachCode(): array {
        $faecherNachCode = [];
        $alleFaecher = $this->clusterRepository->allByClusterTyp(ClusterTyp::getFachTyp());
        foreach ($alleFaecher as $fachAlsCluster) {
            $faecherNachCode[$fachAlsCluster->getCode()->getValue()] = $fachAlsCluster;
        }

        return $faecherNachCode;
    }

    /** @return LernzielFach[] */
    private function allerLernzielFaecherNachLernzielNummer(): array {
        $faecherNachLernzielNummer = [];
        $alleLernzielFaecher = $this->lernzielFachRepository->all();
        foreach ($alleLernzielFaecher as $lernzielFach) {
            $faecherNachLernzielNummer[$lernzielFach->getLernzielNummer()->getValue()] = $lernzielFach;
        }

        return $faecherNachLernzielNummer;
    }

}