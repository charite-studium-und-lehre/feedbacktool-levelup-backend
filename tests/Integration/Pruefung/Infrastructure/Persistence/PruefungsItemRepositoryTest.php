<?php

namespace Tests\Integration\Pruefung\Infrastructure\Persistence;

use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemId;
use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Infrastructure\Persistence\Filesystem\FileBasedSimplePruefungsItemRepository;
use Tests\Integration\Common\DbRepoTestCase;

final class PruefungsItemRepositoryTest extends DbRepoTestCase
{
    protected $dbRepoInterface = PruefungsItemRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [FileBasedSimplePruefungsItemRepository::createTempFileRepo()],
            'db-repo'         => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(PruefungsItemRepository $repo) {
        $pruefungsItem1 = PruefungsItem::create(
            PruefungsItemId::fromInt(123),
            PruefungsId::fromInt(259)
        );
        $pruefungsItem2 = PruefungsItem::create(
            PruefungsItemId::fromInt(456),
            PruefungsId::fromInt(8090)
        );

        $repo->add($pruefungsItem1);
        $repo->add($pruefungsItem2);
        $repo->flush();
        $this->refreshEntities($pruefungsItem1, $pruefungsItem2);

        $this->assertCount(2, $repo->all());
        $pruefungsItem2 = $repo->byId(PruefungsItemId::fromInt(456));
        $this->assertEquals(PruefungsId::fromInt(8090), $pruefungsItem2->getPruefungsId());
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testDelete(PruefungsItemRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $this->assertCount(2, $repo->all());
        foreach ($repo->all() as $entity) {
            $repo->delete($entity);
        }
        $repo->flush();
        $this->assertCount(0, $repo->all());
    }

    protected function clearDatabase(): void {
        // use $this->deleteIdsFromDB or $this->emptyRepositoryWithTruncate()
        $this->emptyRepositoryWithTruncate();
    }

}
