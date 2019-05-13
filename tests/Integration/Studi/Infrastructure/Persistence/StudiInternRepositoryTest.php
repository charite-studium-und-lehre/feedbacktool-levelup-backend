<?php

namespace Tests\Integration\Studi\Infrastructure\Persistence;

use Studi\Domain\Matrikelnummer;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiIntern;
use Studi\Domain\StudiInternRepository;
use Studi\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiInternRepository;
use Tests\Integration\Common\DbRepoTestCase;

final class StudiInternRepositoryTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiInternRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [FileBasedSimpleStudiInternRepository::createTempFileRepo()],
            'db-repo'         => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(StudiInternRepository $repo) {
        $matrikelnummer1 = Matrikelnummer::fromInt(123456);
        $hash1 = StudiHash::fromString(password_hash("test", PASSWORD_ARGON2I));
        $studiIntern1 = StudiIntern::fromMatrikelUndStudiHash($matrikelnummer1, $hash1);
        $matrikelnummer2 = Matrikelnummer::fromInt(456789);
        $hash2 = StudiHash::fromString(password_hash("test2", PASSWORD_ARGON2I));
        $studiIntern2 = StudiIntern::fromMatrikelUndStudiHash($matrikelnummer2, $hash2);

        $repo->add($studiIntern1);
        $repo->add($studiIntern2);
        $repo->flush();
        $this->refreshEntities($studiIntern1, $studiIntern2);

        $this->assertCount(2, $repo->all());
        $studiIntern1 = $repo->byMatrikelnummer($matrikelnummer1);
        $this->assertTrue($matrikelnummer1->equals($studiIntern1->getMatrikelnummer()));
        $this->assertTrue($hash1->equals($studiIntern1->getStudiHash()));


    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testDelete(StudiInternRepository $repo) {
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
