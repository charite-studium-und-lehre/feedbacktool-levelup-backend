<?php

namespace Cluster\Infrastructure\Persistence\Filesystem;

use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterZuordnung;
use Cluster\Domain\ClusterZuordnungsRepository;
use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Pruefung\Domain\PruefungsItemId;

final class FileBasedSimpleClusterZuordnungsRepository extends AbstractCommonRepository implements ClusterZuordnungsRepository
{
    use FileBasedRepoTrait;

    public function addZuordnung(ClusterZuordnung $clusterZuordnung): void {
        if (!$this->sucheAktuelleZuordnung($clusterZuordnung)) {
            $this->add($clusterZuordnung);
        }
    }

    /** @return ClusterId[] */
    public function alleClusterIdsVonPruefungsItem(PruefungsItemId $pruefungsItemId): array {
        $resultArray = [];
        foreach ($this->all() as $aktuelleZuordnung) {
            /* @var $aktuelleZuordnung ClusterZuordnung */
            if ($aktuelleZuordnung->getPruefungsItemId()->equals($pruefungsItemId)) {
                $resultArray[] = $aktuelleZuordnung->getClusterId();
            }
        }

        return $resultArray;
    }

    /** @return PruefungsItemId[] */
    public function allePruefungsItemsVonCluster(ClusterId $clusterId): array {
        $resultArray = [];
        foreach ($this->all() as $aktuelleZuordnung) {
            /* @var $aktuelleZuordnung ClusterZuordnung */
            if ($aktuelleZuordnung->getClusterId()->equals($clusterId)) {
                $resultArray[] = $aktuelleZuordnung->getPruefungsItemId();
            }
        }

        return $resultArray;
    }

    public function delete($clusterZuordnung): void {
        if ($this->sucheAktuelleZuordnung($clusterZuordnung)) {
            parent::delete($clusterZuordnung);
        }
    }

    private function sucheAktuelleZuordnung(ClusterZuordnung $clusterZuordnung): ?ClusterZuordnung {
        foreach ($this->all() as $aktuelleZuordnung) {
            /* @var $aktuelleZuordnung ClusterZuordnung */
            if ($aktuelleZuordnung->equals($clusterZuordnung)) {
                return $aktuelleZuordnung;
            }
        }

        return NULL;
    }

}
