<?php

namespace Tests\Integration\StudiPruefung\Infrastructure\Persistence;

use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiHash;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsId;
use StudiPruefung\Domain\StudiPruefungsRepository;
use StudiPruefung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudienfortschrittRepository;
use StudiPruefung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiPruefungsRepository;
use Tests\Integration\Common\DbRepoTestCase;

final class StudiPruefungsRepositoryTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiPruefungsRepository::class;

    /** @var StudiHash */
    private $studiHash1;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [FileBasedSimpleStudiPruefungsRepository::createTempFileRepo()],
            'db-repo'         => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(StudiPruefungsRepository $repo) {
        $this->studiHash1 = StudiHash::fromString(hash("sha256","test"));
        $studiPruefung1 = StudiPruefung::fromValues(
            StudiPruefungsId::fromInt(123),
            $this->studiHash1,
            PruefungsId::fromString(7890)
        );
        $studiPruefung2 = StudiPruefung::fromValues(
            StudiPruefungsId::fromInt(457),
            StudiHash::fromString(hash("sha256","test2")),
            PruefungsId::fromString(9876)
        );
        $studiPruefung3 = StudiPruefung::fromValues(
            StudiPruefungsId::fromInt(458),
            $this->studiHash1,
            PruefungsId::fromString(9877)
        );

        $repo->add($studiPruefung1);
        $repo->add($studiPruefung2);
        $repo->add($studiPruefung3);
        $repo->flush();
        $this->refreshEntities($studiPruefung1, $studiPruefung2);

        $this->assertCount(3, $repo->all());
        $studiPruefung2 = $repo->byId(StudiPruefungsId::fromInt(457));

        $this->assertEquals(457, $studiPruefung2->getId()->getValue());
        $this->assertEquals(hash("sha256","test2"), $studiPruefung2->getStudiHash()->getValue());
        $this->assertEquals(9876, $studiPruefung2->getPruefungsId()->getValue());
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testDelete(StudiPruefungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $this->assertCount(3, $repo->all());
        foreach ($repo->all() as $entity) {
            $repo->delete($entity);
        }
        $repo->flush();
        $this->assertCount(0, $repo->all());
    }

    /** * @dataProvider getAllRepositories */
    public function testByStudiHashUndPruefungsId(StudiPruefungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $studiPruefung = $repo->byStudiHashUndPruefungsId(
            $this->studiHash1, PruefungsId::fromString(7890)
        );
        $this->assertTrue($studiPruefung->getId()->equals(StudiPruefungsId::fromInt(123)));

        $studiPruefung = $repo->byStudiHashUndPruefungsId(
            $this->studiHash1, PruefungsId::fromString(7891)
        );
        $this->assertNull($studiPruefung);

    }

    /** * @dataProvider getAllRepositories */
    public function testAllByStudiHash(StudiPruefungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $studiPruefungen = $repo->allByStudiHash($this->studiHash1);
        $this->assertCount(2, $studiPruefungen);
    }

    /** * @dataProvider getAllRepositories */
    public function testAllByPruefungsId(StudiPruefungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $studiPruefungen = $repo->allByPruefungsId(PruefungsId::fromString(7890));
        $this->assertCount(1, $studiPruefungen);
    }

    protected function clearDatabase(): void {
        // use $this->deleteIdsFromDB or $this->emptyRepositoryWithTruncate()
        $this->emptyRepositoryWithTruncate();
    }

}
