<?php

namespace Tests\Integration\Studienfortschritt\Infrastructure\Persistence;

use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiHash;
use Studienfortschritt\Domain\FortschrittsItem;
use Studienfortschritt\Domain\StudiMeilenstein;
use Studienfortschritt\Domain\StudiMeilensteinId;
use Studienfortschritt\Domain\StudiMeilensteinRepository;
use Studienfortschritt\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiMeilensteinRepository;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsId;
use StudiPruefung\Domain\StudiPruefungsRepository;
use StudiPruefung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudienfortschrittRepository;
use StudiPruefung\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiPruefungsRepository;
use Tests\Integration\Common\DbRepoTestCase;

final class StudiMeilensteinRepositoryTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiMeilensteinRepository::class;

    /** @var StudiHash */
    private $studiHash1;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [FileBasedSimpleStudiMeilensteinRepository::createTempFileRepo()],
            'db-repo'         => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(StudiMeilensteinRepository $repo) {
        $this->studiHash1 = StudiHash::fromString(hash("sha256","test"));
        $studiMeilenstein1 = StudiMeilenstein::fromValues(
            StudiMeilensteinId::fromInt(123),
            $this->studiHash1,
            FortschrittsItem::fromCode(109)
        );
        $fortschrittsItem2 = FortschrittsItem::fromCode(401, StudiPruefungsId::fromInt(789));
        $studiMeilenstein2 = StudiMeilenstein::fromValues(
            StudiMeilensteinId::fromInt(124),
            $this->studiHash1,
            $fortschrittsItem2,
        );
        $studiMeilenstein3 = StudiMeilenstein::fromValues(
            StudiMeilensteinId::fromInt(125),
            $this->studiHash1,
            FortschrittsItem::fromCode(20)
        );

        $repo->add($studiMeilenstein1);
        $repo->add($studiMeilenstein2);
        $repo->add($studiMeilenstein3);
        $repo->flush();
        $this->refreshEntities($studiMeilenstein1, $studiMeilenstein2, $studiMeilenstein3);

        $this->assertCount(3, $repo->all());
        $recoveredEntity1 = $repo->byId(StudiMeilensteinId::fromInt(124));

        $this->assertEquals(124, $recoveredEntity1->getId()->getValue());
        $this->assertEquals($this->studiHash1, $recoveredEntity1->getStudiHash()->getValue());
        $this->assertEquals($fortschrittsItem2, $recoveredEntity1->getFortschrittsItem());
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testDelete(StudiMeilensteinRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $this->assertCount(3, $repo->all());
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
