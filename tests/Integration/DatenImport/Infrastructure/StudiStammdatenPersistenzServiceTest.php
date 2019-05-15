<?php

namespace Tests\Unit\DatenImport\Infrastructure;

use DatenImport\Domain\StudiStammdatenPersistenzService;
use DatenImport\Infrastructure\Persistence\StudiStammdatenHIS_CSVImportService;
use Studi\Domain\Geburtsdatum;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Studi\Domain\Nachname;
use Studi\Domain\StudiData;
use Studi\Domain\StudiInternRepository;
use Studi\Domain\Vorname;
use Studi\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiInternRepository;
use Studi\Infrastructure\Service\StudiHashCreator_Argon2I;
use Tests\Integration\Common\DbRepoTestCase;

class StudiStammdatenPersistenzServiceTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiInternRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [FileBasedSimpleStudiInternRepository::createTempFileRepo()],
            'db-repo'         => [$this->dbRepo],
        ];
    }

    /**
     * @dataProvider getAllRepositories
     */
    public function testImportStudiInternPersistenz(StudiInternRepository $repository) {

        $studiHashCreator = new StudiHashCreator_Argon2I();
        $csvImportService = new StudiStammdatenHIS_CSVImportService($studiHashCreator);
        $studiStammdatenPersistenzService = new StudiStammdatenPersistenzService(
            $repository,
            $csvImportService,
            $studiHashCreator
        );

        foreach ($repository->all() as $object) {
            $repository->delete($object);
        }
        $repository->flush();

        $this->assertCount(0, $repository->all());

        $studiStammdatenPersistenzService->persistiereStudiListe(
            ["inputFile" => __DIR__ . "/TestFileStudisStammdaten.csv"]
        );

        $this->assertCount(16, $repository->all());

        $this->assertTrue(
            $studiHashCreator->isCorrectStudiHash(
                $repository->byMatrikelnummer(Matrikelnummer::fromInt(221231))
                    ->getStudiHash(),
                StudiData::fromValues(
                    Matrikelnummer::fromInt(221231),
                    Vorname::fromString("Marika"),
                    Nachname::fromString("Heißler"),
                    Geburtsdatum::fromStringDeutschMinus("02-03-1984")
                ))
        );

    }

    protected function clearDatabase(): void {
    }

}