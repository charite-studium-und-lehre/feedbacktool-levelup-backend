<?php

namespace Cluster\Infrastructure\Persistence\Filesystem;

use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterZuordnung;
use Cluster\Domain\ClusterZuordnungsService;
use Common\Infrastructure\Persistence\Common\AbstractCommonRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;
use Lehrberechtigung\Infrastructure\Persistence\Common\AbstractSimpleLehrberechtigungRepository;

final class FileBasedSimpleZuordnungsService extends AbstractCommonRepository implements ClusterZuordnungsService
{
    use FileBasedRepoTrait;

    public function addZuordnung(ClusterZuordnung $clusterZuordnung): void {
        if (!$this->sucheAktuelleZuordnung($clusterZuordnung)) {
            $this->add($clusterZuordnung);
        }
    }

    public function removeZuordnung(ClusterZuordnung $clusterZuordnung): void {
        if ($this->sucheAktuelleZuordnung($clusterZuordnung)) {
            $this->delete($clusterZuordnung);
        }
    }

    /** @return ClusterId[] */
    public function alleClusterVonPruefungsItem(\Pruefung\Domain\PruefungsItemId $wertungsItemId): array {
        $resultArray = [];
        foreach ($this->all() as $aktuelleZuordnung) {
            /* @var $aktuelleZuordnung ClusterZuordnung */
            if ($aktuelleZuordnung->getWertungsItemId()->equals($wertungsItemId)) {
                $resultArray[] = $aktuelleZuordnung->getClusterId();
            }
        }
        return $resultArray;
    }

    /** @return \Pruefung\Domain\PruefungsItemId[] */
    public function allePruefungsItemsVonCluster(ClusterId $clusterId): array {
        $resultArray = [];
        foreach ($this->all() as $aktuelleZuordnung) {
            /* @var $aktuelleZuordnung ClusterZuordnung */
            if ($aktuelleZuordnung->getClusterId()->equals($clusterId)) {
                $resultArray[] = $aktuelleZuordnung->getWertungsItemId();
            }
        }
        return $resultArray;
    }

    private function sucheAktuelleZuordnung(ClusterZuordnung $clusterZuordnung) : ?ClusterZuordnung {
        foreach ($this->all() as $aktuelleZuordnung) {
            /* @var $aktuelleZuordnung ClusterZuordnung */
            if ($aktuelleZuordnung->equals($clusterZuordnung)) {
                return $aktuelleZuordnung;
            }
        }
        return null;
    }
}
