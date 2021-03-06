<?php

namespace DatenImport\Domain;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTyp;

class ChariteLernzielFachPersistenzService
{
    private LernzielFachRepository $lernzielFachRepository;

    private ClusterRepository $clusterRepository;

    public function __construct(LernzielFachRepository $lernzielFachRepository, ClusterRepository $clusterRepository) {
        $this->lernzielFachRepository = $lernzielFachRepository;
        $this->clusterRepository = $clusterRepository;
    }

    /** @param array<int, string> $lernzielFaecher */
    public function persistiereLernzielFaecher(array $lernzielFaecher): void {

        $alleFaecherNachCode = $this->alleFaecherNachCode();
        $alleLernzielFaecherNachLernzielNummer = $this->alleLernzielFaecherNachLernzielNummer();

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
                if ($existierendesLernzielFach->getClusterId()->equals($alleFaecherNachCode[$fachCode]->getId())) {
                    continue;
                }
                $this->lernzielFachRepository->delete($existierendesLernzielFach);
            }

            $neuesLernztielFach = LernzielFach::byIds(
                LernzielNummer::fromInt($lernzielNummer),
                $fachIstCluster->getId()
            );
            echo "+";
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
    private function alleLernzielFaecherNachLernzielNummer(): array {
        $faecherNachLernzielNummer = [];
        $alleLernzielFaecher = $this->lernzielFachRepository->all();
        foreach ($alleLernzielFaecher as $lernzielFach) {
            $faecherNachLernzielNummer[$lernzielFach->getLernzielNummer()->getValue()] = $lernzielFach;
        }

        return $faecherNachLernzielNummer;
    }

}