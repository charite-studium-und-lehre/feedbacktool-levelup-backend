<?php

namespace Tests\Integration\Pruefung\Infrastructure\Persistence;

use Pruefung\Domain\Pruefung;
use Pruefung\Domain\PruefungsPeriode;
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
            PruefungsId::fromString(123),
            PruefungsPeriode::fromInt("201811"),
            PruefungsFormat::fromConst(PruefungsFormat::MC_SEM2)
        );
        $pruefung2 = Pruefung::create(
            PruefungsId::fromString(259),
            PruefungsPeriode::fromInt("20152"),
            PruefungsFormat::fromConst(PruefungsFormat::STATION_TEIL3_SEM4)
        );

        $repo->add($pruefung1);
        $repo->add($pruefung2);
        $repo->flush();
        $this->refreshEntities($pruefung1, $pruefung2);

        $this->assertCount(2, $repo->all());
        $pruefung2 = $repo->byId(PruefungsId::fromString(259));
        $this->assertTrue($pruefung2->getPruefungsPeriode()->equals(PruefungsPeriode::fromInt(20152)));
        $this->assertTrue($pruefung2->getFormat()->equals(PruefungsFormat::fromConst(PruefungsFormat::STATION_TEIL3_SEM4)));
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
