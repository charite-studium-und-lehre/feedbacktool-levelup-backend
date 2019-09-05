<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use DatenImport\Domain\StudiStammdatenPersistenzService;
use DatenImport\Infrastructure\Persistence\ChariteStudiStammdatenHIS_CSVImportService;
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
    public function testImportStudiInternPersistenz(StudiInternRepository $studiInternRepository) {

        $studiHashCreator = new StudiHashCreator_Argon2I();
        $csvImportService = new ChariteStudiStammdatenHIS_CSVImportService();

        $studiStammdatenPersistenzService = new StudiStammdatenPersistenzService(
            $studiInternRepository,
            $studiHashCreator
        );

        foreach ($studiInternRepository->all() as $object) {
            $studiInternRepository->delete($object);
        }
        $studiInternRepository->flush();

        $this->assertCount(0, $studiInternRepository->all());

        $studiObjects = $csvImportService->getStudiData(
            __DIR__ . "/TestFileStudisStammdaten.csv",
            ";",
            FALSE,
            "ISO-8859-15"
        );
        $studiStammdatenPersistenzService->persistiereStudiListe($studiObjects);

        $this->assertCount(16, $studiInternRepository->all());

        $this->assertTrue(
            $studiHashCreator->isCorrectStudiHash(
                $studiInternRepository->byMatrikelnummer(Matrikelnummer::fromInt(221231))
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