<?php

namespace Tests\Integration\StudiPruefung\Infrastructure\Persistence;

use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiHash;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsId;
use StudiPruefung\Domain\StudiPruefungsRepository;
use StudiPruefung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiPruefungsRepository;
use Tests\Integration\Common\DbRepoTestCase;

final class StudiPruefungsRepositoryTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiPruefungsRepository::class;

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
        $studiPruefung1 = StudiPruefung::fromValues(
            StudiPruefungsId::fromInt(123),
            StudiHash::fromString(password_hash("test", PASSWORD_ARGON2I)),
            PruefungsId::fromInt(7890)
        );
        $studiPruefung2 = StudiPruefung::fromValues(
            StudiPruefungsId::fromInt(456),
            StudiHash::fromString(password_hash("test2", PASSWORD_ARGON2I)),
            PruefungsId::fromInt(9876)
        );

        $repo->add($studiPruefung1);
        $repo->add($studiPruefung2);
        $repo->flush();
        $this->refreshEntities($studiPruefung1, $studiPruefung2);

        $this->assertCount(2, $repo->all());
        $studiPruefung2 = $repo->byId(StudiPruefungsId::fromInt(456));

        $this->assertEquals(456, $studiPruefung2->getId()->getValue());
        $this->assertTrue(password_verify("test2", $studiPruefung2->getStudiHash()->getValue()));
        $this->assertEquals(9876, $studiPruefung2->getPruefungsId()->getValue());
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testDelete(StudiPruefungsRepository $repo) {
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
