<?php

namespace Tests\Integration\EPA\Infrastructure\Persistence;

use EPA\Domain\EPA;
use EPA\Domain\EPABewertung;
use EPA\Domain\EPABewertungsDatum;
use EPA\Domain\SelbstBewertung\SelbstBewertung;
use EPA\Domain\SelbstBewertung\SelbstBewertungsId;
use EPA\Domain\SelbstBewertung\SelbstBewertungsRepository;
use EPA\Domain\SelbstBewertung\SelbstBewertungsTyp;
use EPA\Infrastructure\Persistence\Filesystem\FileBasedSimpleSelbstBewertungsRepository;
use Studi\Domain\LoginHash;
use Tests\Integration\Common\DbRepoTestCase;
use Tests\Unit\EPA\Domain\SelbstBewertungsTest;

final class SelbstBewertungsRepositoryTest extends DbRepoTestCase
{

    const LOGIN_HASH = '0062a008dbcd86fa8d0738e1f6e0f5daefe9fd2a7a9dddcacefd2a7a9dddcace';
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
            LoginHash::fromString(self::LOGIN_HASH),
            EPABewertung::fromValues(4, $epa),
            SelbstBewertungsTyp::getGemachtObject()
        );
        $selbstbewertung1b = SelbstBewertung::create(
            SelbstBewertungsId::fromInt(124),
            LoginHash::fromString(self::LOGIN_HASH),
            EPABewertung::fromValues(3, $epa),
            SelbstBewertungsTyp::getGemachtObject()
        );
        SelbstBewertungsTest::setzeDatumMitReflectionAuf(
            $selbstbewertung1b,
            EPABewertungsDatum::fromString("02.09.2018")
        );
        $selbstbewertung2 = SelbstBewertung::create(
            SelbstBewertungsId::fromInt(456),
            LoginHash::fromString(self::LOGIN_HASH),
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
        $this->assertTrue($selbstbewertung->getLoginHash()
                              ->equals($selbstbewertung1->getLoginHash()));
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
        $this->assertEquals(EPABewertung::fromValues(5, EPA::fromInt(111)),
                            $selbstbewertung->getEpaBewertung());
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testGetLatest(SelbstBewertungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $latestObjectsGemacht = $repo->allLatestByStudiUndTyp(
            LoginHash::fromString(self::LOGIN_HASH),
            SelbstBewertungsTyp::getGemachtObject()
        );
        $latestObjectsZutrauen = $repo->allLatestByStudiUndTyp(
            LoginHash::fromString(self::LOGIN_HASH),
            SelbstBewertungsTyp::getZutrauenObject()
        );

        $this->assertCount(1, $latestObjectsGemacht);
        $this->assertCount(1, $latestObjectsZutrauen);
        $this->assertTrue(
            $latestObjectsGemacht[0]->getEpaBewertung()->getEpa()->equals(
                EPA::fromInt(111))
        );
        $this->assertEquals(4, $latestObjectsGemacht[0]->getEpaBewertung()->getBewertung());
        $this->assertEquals(0, $latestObjectsZutrauen[0]->getEpaBewertung()->getBewertung());
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testByStudiId(SelbstBewertungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $all =
            $repo->allByStudi(LoginHash::fromString(self::LOGIN_HASH));
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
