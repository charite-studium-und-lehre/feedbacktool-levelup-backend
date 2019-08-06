<?php

namespace Tests\Integration\DatenImport\Infrastructure\Persistence;

use Cluster\Domain\ClusterId;
use DatenImport\Domain\LernzielFach;
use DatenImport\Domain\LernzielFachRepository;
use DatenImport\Domain\LernzielNummer;
use DatenImport\Infrastructure\Persistence\Filesystem\FileBasedSimpleLernzielFachRepository;
use Tests\Integration\Common\DbRepoTestCase;

final class LernzielFachRepositoryTest extends DbRepoTestCase
{
    protected $dbRepoInterface = LernzielFachRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-service' => [FileBasedSimpleLernzielFachRepository::createTempFileRepo()],
            'db-service'         => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function anfangs_leer(LernzielFachRepository $lernzielFachRepository) {
        $this->assertEmpty($lernzielFachRepository->all());
        $this->assertEmpty($lernzielFachRepository->getFachByLernzielNummer(LernzielNummer::fromInt(1)));
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(LernzielFachRepository $lernzielFachRepository) {
        $lernzielFach = LernzielFach::byIds(LernzielNummer::fromInt(123),
                                            ClusterId::fromInt(456));

        $lernzielFachRepository->addLernzielFach($lernzielFach);
        $lernzielFachRepository->flush();
        $this->refreshEntities($lernzielFach);

        $lernzielFach = $lernzielFachRepository->getFachByLernzielNummer(LernzielNummer::fromInt(123));
        $this->assertTrue($lernzielFach->equals(ClusterId::fromInt(456)));
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_loeschen(LernzielFachRepository $lernzielFachRepository) {
        $this->kann_speichern_und_wiederholen($lernzielFachRepository);

        $lernzielFach = $lernzielFachRepository->all()[0];
        $lernzielFachRepository->delete($lernzielFach);
        $lernzielFachRepository->flush();

        $this->assertEmpty($lernzielFachRepository->all());
    }

    public function clearDatabase(): void {
        $this->emptyRepoTableWithDelete();
    }

}
