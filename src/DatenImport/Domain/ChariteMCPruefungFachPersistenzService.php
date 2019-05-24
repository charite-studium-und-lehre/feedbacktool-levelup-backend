<?php

namespace DatenImport\Domain;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTypId;
use Cluster\Domain\ClusterZuordnung;
use Cluster\Domain\ClusterZuordnungsService;
use Pruefung\Domain\PruefungsItemRepository;
use Studi\Domain\StudiIntern;

class ChariteMCPruefungFachPersistenzService
{
    /** @var PruefungsItemRepository */
    private $pruefungsItemRepository;

    /** @var ClusterRepository */
    private $clusterRepository;

    /** @var ClusterZuordnungsService */
    private $clusterZuordnungsService;

    public function __construct(
        PruefungsItemRepository $pruefungsItemRepository,
        ClusterRepository $clusterRepository,
        ClusterZuordnungsService $clusterZuordnungsService
    ) {
        $this->pruefungsItemRepository = $pruefungsItemRepository;
        $this->clusterRepository = $clusterRepository;

        $this->clusterZuordnungsService = $clusterZuordnungsService;
    }

    /** @param StudiIntern[] $studiInternArray */
    public function persistiereFachZuordnung($mcPruefungsDaten) {

        foreach ($mcPruefungsDaten as [$matrikelnummer, $punktzahl, $pruefungsItemId, $clusterTitel]) {

            if (!$clusterTitel) {
                foreach ($this->clusterZuordnungsService->alleClusterVonPruefungsItem($pruefungsItemId)
                    as $aktuellezuordnung) {
                    $this->clusterZuordnungsService->removeZuordnung($aktuellezuordnung);
                }
                $this->clusterZuordnungsService->flush();
                continue;
            }

            $clusterFach = $this->clusterRepository->byClusterTypIdUndTitel(
                ClusterTypId::fromInt(ClusterTypId::TYP_ID_FACH),
                $clusterTitel
            );
            if (!$clusterFach) {
                $clusterFach = Cluster::create(
                    $this->clusterRepository->nextIdentity(),
                    ClusterTypId::fromInt(ClusterTypId::TYP_ID_FACH),
                    $clusterTitel
                );
                $this->clusterRepository->add($clusterFach);
                $this->clusterRepository->flush();
            }

            $existierendeZuordnungen = $this->clusterZuordnungsService->alleClusterVonPruefungsItem($pruefungsItemId);
            $zuordnungGefunden = FALSE;
            foreach ($existierendeZuordnungen as $clusterIdZugeordnet) {
                if ($clusterIdZugeordnet->equals($clusterFach->getId())) {
                    $zuordnungGefunden = TRUE;
                } else {
                    $this->clusterZuordnungsService->removeZuordnung(
                        ClusterZuordnung::byIds(
                            $clusterIdZugeordnet,
                            $pruefungsItemId
                        )
                    );
                }
            }
            if (!$zuordnungGefunden) {
                $zuordnungVonItem = ClusterZuordnung::byIds(
                    $clusterFach->getId(),
                    $pruefungsItemId
                );
                $this->clusterZuordnungsService->addZuordnung($zuordnungVonItem);
            }
            $this->clusterZuordnungsService->flush();
        }

    }

}