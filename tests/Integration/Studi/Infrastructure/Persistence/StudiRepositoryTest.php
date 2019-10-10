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

    private $loginHash;

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(StudiRepository $repo) {
        $hash1 = StudiHash::fromString(hash("sha256","test"));
        $studi1 = Studi::fromStudiHash($hash1);
        $hash2 = StudiHash::fromString(hash("sha256","test2"));
        $studi2 = Studi::fromStudiHash($hash2);
        $this->loginHash = LoginHash::fromString(hash("sha256", "login"));
        $studi2->setLoginHash($this->loginHash);

        $repo->add($studi1);
        $repo->add($studi2);
        $repo->flush();
        $this->refreshEntities($studi1, $studi2);

        $this->assertCount(2, $repo->all());
        $studi1 = $repo->byStudiHash($hash1);
        $this->assertEquals($hash1->getValue(), $studi1->getStudiHash()->getValue());
        $this->assertNull($studi1->getLoginHash());
        $studi2 = $repo->byStudiHash($hash2);
        $this->assertEquals($this->loginHash->getValue(), $studi2->getLoginHash()->getValue());
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function byLoginHash(StudiRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $studiByLoginHash = $repo->byLoginHash($this->loginHash);
        $this->assertTrue($studiByLoginHash->getLoginHash()->equals($this->loginHash));
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testDelete(StudiRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $this->assertCount(2, $repo->all());
        foreach ($repo->all() as $entity) {
            $this->refreshEntities($entity);
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
