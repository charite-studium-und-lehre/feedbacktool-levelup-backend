<?php

namespace Tests\Integration\Cluster\Infrastructure\Persistence;

use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterZuordnung;
use Cluster\Domain\ClusterZuordnungsRepository;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleZuordnungsRepository;
use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemId;
use Tests\Integration\Common\DbRepoTestCase;

final class ClusterZuordnungsRepositoryTest extends DbRepoTestCase
{
    protected $dbRepoInterface = ClusterZuordnungsRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-service' => [FileBasedSimpleZuordnungsRepository::createTempFileRepo()],
            'db-service'         => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function anfangs_leer(ClusterZuordnungsRepository $zuordnungsService) {
        $this->assertEmpty($zuordnungsService->allePruefungsItemsVonCluster(ClusterId::fromInt(2)));
        $this->assertEmpty($zuordnungsService->alleClusterIdsVonPruefungsItem(PruefungsItemId::fromString(3)));
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(ClusterZuordnungsRepository $zuordnungsService) {
        $zuordnung = $this->createZuordnung();

        $zuordnungsService->addZuordnung($zuordnung);
        $zuordnungsService->flush();
        $this->refreshEntities($zuordnung);

        $pruefungsItemIds = $zuordnungsService->allePruefungsItemsVonCluster(ClusterId::fromInt(2));
        $this->assertCount(1, $pruefungsItemIds);
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_loeschen(ClusterZuordnungsRepository $zuordnungsService) {
        $this->kann_speichern_und_wiederholen($zuordnungsService);

        $zuordnungsService->delete($this->createZuordnung());
        $zuordnungsService->flush();

        $pruefungsItemIds = $zuordnungsService->allePruefungsItemsVonCluster(ClusterId::fromInt(2));
        $this->assertCount(0, $pruefungsItemIds);
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function mehrfach_anlegen_wird_abgefangen(ClusterZuordnungsRepository $zuordnungsService) {
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
    public function mehrfach_loeschen_ist_kein_fehler(ClusterZuordnungsRepository $zuordnungsService) {
        $this->kann_speichern_und_wiederholen($zuordnungsService);

        $zuordnungsService->delete($this->createZuordnung());
        $zuordnungsService->delete($this->createZuordnung());
        $zuordnungsService->flush();
        $zuordnungsService->delete($this->createZuordnung());
        $zuordnungsService->flush();

        $pruefungsItemIds = $zuordnungsService->allePruefungsItemsVonCluster(ClusterId::fromInt(2));
        $this->assertCount(0, $pruefungsItemIds);
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_mehrfach_holen(ClusterZuordnungsRepository $zuordnungsService) {

        $zuordnungsService->addZuordnung($this->createZuordnung(2, 30));
        $zuordnungsService->addZuordnung($this->createZuordnung(2, 31));
        $zuordnungsService->addZuordnung($this->createZuordnung(3, 30));
        $zuordnungsService->addZuordnung($this->createZuordnung(3, 31));
        $zuordnungsService->flush();

        $pruefungsItemIds = $zuordnungsService->allePruefungsItemsVonCluster(ClusterId::fromInt(2));
        $this->assertCount(2, $pruefungsItemIds);

        $clusterIds = $zuordnungsService->alleClusterIdsVonPruefungsItem(PruefungsItemId::fromString(30));
        $this->assertCount(2, $clusterIds);
    }

    protected function clearDatabase(): void {
        // use $this->deleteIdsFromDB or $this->emptyRepository()
        $this->emptyRepositoryWithTruncate();
    }

    /**
     * @return ClusterZuordnung
     */
    private function createZuordnung(int $idCluster = 2, int $idItem = 3): ClusterZuordnung {
        $zuordnung = ClusterZuordnung::byIds(ClusterId::fromInt($idCluster),
                                             PruefungsItemId::fromString($idItem));

        return $zuordnung;
    }

}
