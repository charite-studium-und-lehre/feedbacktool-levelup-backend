<?php

namespace Tests\Integration\Cluster\Infrastructure\Persistence;


use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTitel;
use Cluster\Domain\ClusterTypId;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleClusterRepository;
use Tests\Integration\Common\DbRepoTestCase;

final class ClusterRepositoryTest extends DbRepoTestCase
{
//    protected $dbRepoInterface = ClusterRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-cluster-repository' => [FileBasedSimpleClusterRepository::createTempFileRepo()],
//            'db-repo'                                => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(ClusterRepository $repo) {
        $cluster1 = Cluster::create(
            ClusterId::fromInt(5),
            ClusterTypId::fromInt(25),
            ClusterTitel::fromString("Anatomie"),
            null
        );
        $cluster2 = Cluster::create(
            ClusterId::fromInt(6),
            ClusterTypId::fromInt(26),
            ClusterTitel::fromString("Chemie"),
            $cluster1->getId()
        );
        $repo->add($cluster1);
        $repo->add($cluster2);
        $repo->flush();

        $this->assertCount(2, $repo->all());
        $cluster2 = $repo->byId(ClusterId::fromInt(6));
        $this->assertEquals(ClusterTitel::fromString("Chemie"), $cluster2->getClusterTypId());
        $this->assertEquals(ClusterId::fromInt(5), $cluster2->getParentId());
        $this->assertEquals(ClusterTypId::fromInt(26), $cluster2->getClusterTypId());

    }

    public function testDelete(ClusterRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $this->assertCount(2, $repo->all());
        foreach ($repo->all() as $entity) {
            $repo->delete($entity);
        }
        $repo->flush();
        $this->assertCount(0, $repo->all());
    }

    protected function clearDatabase() {
        // use $this->deleteIdsFromDB or $this->emptyRepository()
        $this->emptyRepository();
    }



}
