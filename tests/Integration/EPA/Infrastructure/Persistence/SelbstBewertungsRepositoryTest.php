<?php

namespace Tests\Integration\EPA\Infrastructure\Persistence;

use EPA\Domain\EPA;
use EPA\Domain\EPABewertung;
use EPA\Domain\EPABewertungsDatum;
use EPA\Domain\SelbstBewertung;
use EPA\Domain\SelbstBewertungsId;
use EPA\Domain\SelbstBewertungsRepository;
use EPA\Domain\SelbstBewertungsTyp;
use EPA\Infrastructure\Persistence\Filesystem\FileBasedSimpleSelbstBewertungsRepository;
use Studi\Domain\StudiHash;
use Tests\Integration\Common\DbRepoTestCase;
use Tests\Unit\EPA\Domain\SelbstBewertungsTest;

final class SelbstBewertungsRepositoryTest extends DbRepoTestCase
{
    protected $dbRepoInterface = SelbstBewertungsRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [FileBasedSimpleSelbstBewertungsRepository::createTempFileRepo()],
            'db-repo'         => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(SelbstBewertungsRepository $repo) {
        $epa = EPA::fromInt(111);
        $selbstbewertung1 = SelbstBewertung::create(
            SelbstBewertungsId::fromInt(123),
            StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$SjNFNWJPNXVFTkVoaEEwcQ$xrpCKHbfjfjRLrn0K1keYfk6SCFlGQfWuT7edgpaO8E'),
            EPABewertung::fromValues(3, $epa),
            SelbstBewertungsTyp::getGemachtObject()
        );
        $selbstbewertung1b = SelbstBewertung::create(
            SelbstBewertungsId::fromInt(124),
            StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$SjNFNWJPNXVFTkVoaEEwcQ$xrpCKHbfjfjRLrn0K1keYfk6SCFlGQfWuT7edgpaO8E'),
            EPABewertung::fromValues(4, $epa),
            SelbstBewertungsTyp::getGemachtObject()
        );
        SelbstBewertungsTest::setzeDatumMitReflectionAuf(
            $selbstbewertung1b,
            EPABewertungsDatum::fromString("02.09.2018")
        );
        $selbstbewertung2 = SelbstBewertung::create(
            SelbstBewertungsId::fromInt(456),
            StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$SjNFNWJPNXVFTkVoaEEwcQ$xrpCKHbfjfjRLrn0K1keYfk6SCFlGQfWuT7edgpaO8E'),
            EPABewertung::fromValues(0, $epa),
            SelbstBewertungsTyp::getZutrauenObject()
        );

        $repo->add($selbstbewertung1);
        $repo->add($selbstbewertung1b);
        $repo->add($selbstbewertung2);
        $repo->flush();
        $this->refreshEntities($selbstbewertung1, $selbstbewertung1b, $selbstbewertung2);

        $this->assertCount(3, $repo->all());
        $selbstbewertung = $repo->byId(SelbstBewertungsId::fromInt(123));
        $this->assertTrue($selbstbewertung->getId()
                              ->equals($selbstbewertung1->getId()));
        $this->assertTrue($selbstbewertung->getStudiHash()
                              ->equals($selbstbewertung1->getStudiHash()));
        $this->assertTrue($selbstbewertung->getEpaBewertung()
                              ->equals($selbstbewertung1->getEpaBewertung()));
        $this->assertTrue($selbstbewertung->getSelbstBewertungsTyp()
                              ->equals($selbstbewertung1->getSelbstBewertungsTyp()));
        $this->assertTrue($selbstbewertung->getEpaBewertungsDatum()
                              ->equals($selbstbewertung1->getEpaBewertungsDatum()));

    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_bewertungs_aenderung_speichern(SelbstBewertungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $selbstbewertung = $repo->byId(SelbstBewertungsId::fromInt(123));
        $selbstbewertung->erhoeheBewertung();
        $repo->flush();
        $this->refreshEntities($selbstbewertung);
        $this->assertEquals(EPABewertung::fromValues(4, EPA::fromInt(111)),
                            $selbstbewertung->getEpaBewertung());
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testGetLatest(SelbstBewertungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $latestObject = $repo->latestByStudiUndTyp(
            StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$SjNFNWJPNXVFTkVoaEEwcQ$xrpCKHbfjfjRLrn0K1keYfk6SCFlGQfWuT7edgpaO8E'),
            SelbstBewertungsTyp::getGemachtObject()
        );
        $this->assertTrue($latestObject->getId()->equals(SelbstBewertungsId::fromInt(123)));
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testByStudiId(SelbstBewertungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $all =
            $repo->allByStudi(StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$SjNFNWJPNXVFTkVoaEEwcQ$xrpCKHbfjfjRLrn0K1keYfk6SCFlGQfWuT7edgpaO8E'));
        $this->assertCount(3, $all);
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testDelete(SelbstBewertungsRepository $repo) {
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
