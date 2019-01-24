<?php

namespace Cluster\Infrastructure\Persistence\DB;

use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterZuordnung;
use Cluster\Domain\ClusterZuordnungsService;
use Common\Infrastructure\Persistence\DB\DoctrineFlushTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Pruefung\Domain\PruefungsItemId;

final class DBClusterZuordnungsService implements ClusterZuordnungsService
{
    use DoctrineFlushTrait;

    /** @var EntityRepository */
    private $doctrineRepo;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityRepository $doctrineRepository, EntityManagerInterface $entityManager) {
        $this->doctrineRepo = $doctrineRepository;
        $this->entityManager = $entityManager;
    }

    public function addZuordnung(ClusterZuordnung $clusterZuordnung): void {
        if (!$this->sucheAktuelleZuordnung($clusterZuordnung)) {
            $this->entityManager->persist($clusterZuordnung);
        }
    }

    public function removeZuordnung(ClusterZuordnung $clusterZuordnung): void {
        $gefundeneZuordnung = $this->sucheAktuelleZuordnung($clusterZuordnung);
        if ($gefundeneZuordnung) {
            $this->entityManager->remove($gefundeneZuordnung);
        }
    }

    /** @return ClusterId[] */
    public function alleClusterVonPruefungsItem(PruefungsItemId $wertungsItemId): array {
        return $this->doctrineRepo
            ->findBy(
                ["wertungsItemId" => $wertungsItemId]
            );
    }

    /** @return \Pruefung\Domain\PruefungsItemId[] */
    public function allePruefungsItemsVonCluster(ClusterId $clusterId): array {
        return $this->doctrineRepo
            ->findBy(
                ["clusterId" => $clusterId]
            );
    }

    private function sucheAktuelleZuordnung(ClusterZuordnung $clusterZuordnung) : ?ClusterZuordnung {
        return $this->doctrineRepo->findOneBy(
            [
                "wertungsItemId" => $clusterZuordnung->getWertungsItemId(),
                "clusterId"      => $clusterZuordnung->getClusterId()]
        );
    }
}