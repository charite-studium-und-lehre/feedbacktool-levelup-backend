<?php

namespace Tests\Integration\Studi\Infrastructure\Persistence;

use Studi\Domain\LoginHash;
use Studi\Domain\Studi;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiRepository;
use Studi\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiRepository;
use Tests\Integration\Common\DbRepoTestCase;

final class StudiRepositoryTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [FileBasedSimpleStudiRepository::createTempFileRepo()],
            'db-repo'         => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(StudiRepository $repo) {
        $hash1 = StudiHash::fromString(password_hash("test", PASSWORD_ARGON2I));
        $studi1 = Studi::fromStudiHash($hash1);
        $hash2 = StudiHash::fromString(password_hash("test2", PASSWORD_ARGON2I));
        $studi2 = Studi::fromStudiHash($hash2);
        $loginHash = LoginHash::fromString(password_hash("login", PASSWORD_ARGON2I));
        $studi2->setLoginHash($loginHash);

        $repo->add($studi1);
        $repo->add($studi2);
        $repo->flush();

        $this->assertCount(2, $repo->all());
        $studi1 = $repo->byHash($hash1);
        $this->assertEquals($hash1->getValue(), $studi1->getStudiHash()->getValue());
        $this->assertNull($studi1->getLoginHash());
        $studi2 = $repo->byHash($hash2);
        $this->assertEquals($loginHash->getValue(), $studi2->getLoginHash()->getValue());
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testDelete(StudiRepository $repo) {
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
