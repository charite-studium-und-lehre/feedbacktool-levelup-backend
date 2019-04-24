<?php

namespace Tests\Integration\Pruefung\Infrastructure\Persistence;

use Pruefung\Domain\Pruefung;
use Pruefung\Domain\PruefungsDatum;
use Pruefung\Domain\PruefungsFormat;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsRepository;
use Pruefung\Infrastructure\Persistence\Filesystem\FileBasedSimplePruefungsRepository;
use Tests\Integration\Common\DbRepoTestCase;

final class PruefungsRepositoryTest extends DbRepoTestCase
{
    protected $dbRepoInterface = PruefungsRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [FileBasedSimplePruefungsRepository::createTempFileRepo()],
            'db-repo'         => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(PruefungsRepository $repo) {
        $pruefung1 = Pruefung::create(
            PruefungsId::fromInt(123),
            PruefungsDatum::fromString("10.12.2018"),
            PruefungsFormat::fromConst(PruefungsFormat::MC)
        );
        $pruefung2 = Pruefung::create(
            PruefungsId::fromInt(259),
            PruefungsDatum::fromString("31.01.2015"),
            PruefungsFormat::fromConst(PruefungsFormat::OSCE)
        );

        $repo->add($pruefung1);
        $repo->add($pruefung2);
        $repo->flush();
        $this->refreshEntities($pruefung1, $pruefung2);

        $this->assertCount(2, $repo->all());
        $pruefung2 = $repo->byId(PruefungsId::fromInt(259));
        $this->assertTrue($pruefung2->getDatum()->equals(PruefungsDatum::fromString("31.01.2015")));
        $this->assertTrue($pruefung2->getFormat()->equals(PruefungsFormat::fromConst(PruefungsFormat::OSCE)));
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testDelete(PruefungsRepository $repo) {
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
