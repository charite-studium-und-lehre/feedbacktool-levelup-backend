<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use Common\Domain\User\Nachname;
use Common\Domain\User\Vorname;
use DatenImport\Domain\StudiStammdatenPersistenzService;
use DatenImport\Infrastructure\Persistence\ChariteStudiStammdatenHIS_CSVImportService;
use Studi\Domain\Geburtsdatum;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Studi\Domain\StudiData;
use Studi\Domain\StudiInternRepository;
use Studi\Domain\StudiRepository;
use Studi\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiInternRepository;
use Studi\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiRepository;
use Studi\Infrastructure\Service\StudiHashCreator_Argon2I;
use Tests\Integration\Common\DbRepoTestCase;

class StudiStammdatenPersistenzServiceTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiInternRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [
                FileBasedSimpleStudiInternRepository::createTempFileRepo(),
                FileBasedSimpleStudiRepository::createTempFileRepo(),
            ],
            'db-repo'         => [
                $this->currentContainer->get(StudiInternRepository::class),
                $this->currentContainer->get(StudiRepository::class),
            ],
        ];
    }

    /**
     * @dataProvider getAllRepositories
     */
    public function testImportStudiInternPersistenz(
        StudiInternRepository $studiInternRepository,
        StudiRepository $studiRepository
    ) {

        $studiHashCreator = new StudiHashCreator_Argon2I();
        $csvImportService = new ChariteStudiStammdatenHIS_CSVImportService();

        $studiStammdatenPersistenzService = new StudiStammdatenPersistenzService(
            $studiInternRepository,
            $studiRepository,
            $studiHashCreator
        );

        foreach ($studiInternRepository->all() as $object) {
            $studiInternRepository->delete($object);
        }
        $studiInternRepository->flush();

        $this->assertCount(0, $studiInternRepository->all());

        $studiObjects = $csvImportService->getStudiData(
            __DIR__ . "/TestFileStudisStammdaten.csv",
            ",",
            TRUE,
            "UTF-8"
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
                    Geburtsdatum::fromStringDeutschMinus("02-03-1984"),
                    []
                ))
        );

    }

}