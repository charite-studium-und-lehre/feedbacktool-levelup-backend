<?php

namespace Tests\Integration\Cluster\Infrastructure\Persistence;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterCode;
use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTitel;
use Cluster\Domain\ClusterTypId;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleClusterRepository;
use Tests\Integration\Common\DbRepoTestCase;

final class ClusterRepositoryTest extends DbRepoTestCase
{
    protected $dbRepoInterface = ClusterRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [FileBasedSimpleClusterRepository::createTempFileRepo()],
            'db-repo'         => [$this->dbRepo],
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
            NULL
        );
        $cluster2 = Cluster::create(
            ClusterId::fromInt(6),
            ClusterTypId::fromInt(26),
            ClusterTitel::fromString("Chemie"),
            $cluster1->getId(),
            ClusterCode::fromString("F01")
        );
        $cluster3 = Cluster::create(
            ClusterId::fromInt(7),
            ClusterTypId::fromInt(27),
            ClusterTitel::fromString("Allgemeinmedizin"),
            NULL,
            ClusterCode::fromString("F02")
        );
        $repo->add($cluster1);
        $repo->add($cluster2);
        $repo->add($cluster3);
        $repo->flush();
        $this->refreshEntities($cluster1, $cluster2, $cluster3);

        $this->assertCount(3, $repo->all());
        $cluster2 = $repo->byId(ClusterId::fromInt(6));
        $this->assertEquals(ClusterTitel::fromString("Chemie"), $cluster2->getTitel());
        $this->assertEquals(ClusterId::fromInt(5), $cluster2->getParentId());
        $this->assertEquals(ClusterTypId::fromInt(26), $cluster2->getClusterTypId());
        $this->assertEquals(ClusterCode::fromString("F02"), $cluster3->getCode());

    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testDelete(ClusterRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $this->assertCount(3, $repo->all());
        foreach ($repo->all() as $entity) {
            $repo->delete($entity);
        }
        $repo->flush();
        $this->assertCount(0, $repo->all());
    }

    /**
     * @dataProvider getAllRepositories
     */
    public function testAllByClusterTypId(ClusterRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $clustersByTyp = $repo->allByClusterTypId(ClusterTypId::fromInt(26));
        $this->assertCount(1, $clustersByTyp);
        $this->assertTrue($clustersByTyp[0]->getId()->equals(ClusterId::fromInt(6)));
    }

    /**
     * @dataProvider getAllRepositories
     */
    public function testByClusterTypIdUndTitel(ClusterRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $cluster = $repo->byClusterTypIdUndTitel(
            ClusterTypId::fromInt(26),
            ClusterTitel::fromString("Chemie")
        );
        $this->assertNotNull($cluster);
        $this->assertTrue($cluster->getId()->equals(ClusterId::fromInt(6)));
    }

    /**
     * @dataProvider getAllRepositories
     */
    public function testByClusterCode(ClusterRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $cluster = $repo->byCode(ClusterCode::fromString("F01"));
        $this->assertNotNull($cluster);
        $this->assertTrue($cluster->getId()->equals(ClusterId::fromInt(6)));
    }

    protected function clearDatabase(): void {
        // use $this->deleteIdsFromDB or $this->emptyRepositoryWithTruncate()
        $this->emptyRepositoryWithTruncate();
    }

}
