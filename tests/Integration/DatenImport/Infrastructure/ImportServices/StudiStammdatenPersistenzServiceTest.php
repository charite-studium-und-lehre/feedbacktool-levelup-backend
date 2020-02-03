<?php

namespace Tests\Integration\DatenImport\Infrastructure\ImportServices;

use Common\Domain\User\Nachname;
use Common\Domain\User\Vorname;
use DatenImport\Domain\StudiStammdatenPersistenzService;
use DatenImport\Infrastructure\Persistence\ChariteStudiStammdatenHIS_CSVImportService;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Studi\Domain\StudiData;
use Studi\Domain\StudiInternRepository;
use Studi\Domain\StudiRepository;
use Studi\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiInternRepository;
use Studi\Infrastructure\Persistence\Filesystem\FileBasedSimpleStudiRepository;
use Studi\Infrastructure\Service\StudiHashCreator_SHA256;
use Tests\Integration\Common\DbRepoTestCase;

class StudiStammdatenPersistenzServiceTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiInternRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [
                FileBasedSimpleStudiInternRepository::createTempFileRepo(),
            ],
            'db-repo'         => [
                $this->currentContainer->get(StudiInternRepository::class),
            ],
        ];
    }

    /**
     * @dataProvider getAllRepositories
     */
    public function testImportStudiInternPersistenz(StudiInternRepository $studiInternRepository) {

        $studiHashCreator = new StudiHashCreator_SHA256("test");
        $csvImportService = new ChariteStudiStammdatenHIS_CSVImportService();

        $studiStammdatenPersistenzService = new StudiStammdatenPersistenzService(
            $studiInternRepository,
            $studiHashCreator
        );

        $this->clearRepos([$studiInternRepository]);

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
                    ))
        );

    }

}