<?php

namespace Tests\Integration\Cluster\Infrastructure\Persistence;

use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterZuordnung;
use Cluster\Domain\ClusterZuordnungsService;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleZuordnungsService;
use Pruefung\Domain\PruefungsItemId;
use Tests\Integration\Common\DbRepoTestCase;

final class ClusterZuordnungsServiceTest extends DbRepoTestCase
{
    protected $dbRepoInterface = ClusterZuordnungsService::class;

    public function getAllRepositories() {

        return [
            'file-based-service' => [FileBasedSimpleZuordnungsService::createTempFileRepo()],
            'db-service'         => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function anfangs_leer(ClusterZuordnungsService $zuordnungsService) {
        $this->assertEmpty($zuordnungsService->allePruefungsItemsVonCluster(ClusterId::fromInt(2)));
        $this->assertEmpty($zuordnungsService->alleClusterVonPruefungsItem(PruefungsItemId::fromInt(3)));
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(ClusterZuordnungsService $zuordnungsService) {
        $zuordnung = $this->createZuordnung();

        $zuordnungsService->addZuordnung($zuordnung);
        $zuordnungsService->flush();

        $pruefungsItemIds = $zuordnungsService->allePruefungsItemsVonCluster(ClusterId::fromInt(2));
        $this->assertCount(1, $pruefungsItemIds);
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_loeschen(ClusterZuordnungsService $zuordnungsService) {
        $this->kann_speichern_und_wiederholen($zuordnungsService);

        $zuordnungsService->removeZuordnung($this->createZuordnung());
        $zuordnungsService->flush();

        $pruefungsItemIds = $zuordnungsService->allePruefungsItemsVonCluster(ClusterId::fromInt(2));
        $this->assertCount(0, $pruefungsItemIds);
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function mehrfach_anlegen_wird_abgefangen(ClusterZuordnungsService $zuordnungsService) {
        $zuordnungsService->addZuordnung($this->createZuordnung());
        $zuordnungsService->flush();
        $zuordnungsService->addZuordnung($this->createZuordnung());
        $zuordnungsService->flush();

        $pruefungsItemIds = $zuordnungsService->allePruefungsItemsVonCluster(ClusterId::fromInt(2));
        $this->assertCount(1, $pruefungsItemIds);
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function mehrfach_loeschen_ist_kein_fehler(ClusterZuordnungsService $zuordnungsService) {
        $this->kann_speichern_und_wiederholen($zuordnungsService);

        $zuordnungsService->removeZuordnung($this->createZuordnung());
        $zuordnungsService->removeZuordnung($this->createZuordnung());
        $zuordnungsService->flush();
        $zuordnungsService->removeZuordnung($this->createZuordnung());
        $zuordnungsService->flush();

        $pruefungsItemIds = $zuordnungsService->allePruefungsItemsVonCluster(ClusterId::fromInt(2));
        $this->assertCount(0, $pruefungsItemIds);
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_mehrfach_holen(ClusterZuordnungsService $zuordnungsService) {

        $zuordnungsService->addZuordnung($this->createZuordnung(2, 30));
        $zuordnungsService->addZuordnung($this->createZuordnung(2, 31));
        $zuordnungsService->addZuordnung($this->createZuordnung(3, 30));
        $zuordnungsService->addZuordnung($this->createZuordnung(3, 31));
        $zuordnungsService->flush();

        $pruefungsItemIds = $zuordnungsService->allePruefungsItemsVonCluster(ClusterId::fromInt(2));
        $this->assertCount(2, $pruefungsItemIds);

        $clusterIds = $zuordnungsService->alleClusterVonPruefungsItem(PruefungsItemId::fromInt(30));
        $this->assertCount(2, $clusterIds);
    }


    protected function clearDatabase() {
        // use $this->deleteIdsFromDB or $this->emptyRepository()
        $this->emptyRepository();
    }

    /**
     * @return ClusterZuordnung
     */
    private function createZuordnung(int $idCluster = 2, int $idItem = 3): ClusterZuordnung {
        $zuordnung = ClusterZuordnung::byIds(ClusterId::fromInt($idCluster),
                                             PruefungsItemId::fromInt($idItem));

        return $zuordnung;
    }

}
