<?php

namespace tests\Integration\DatenImport\Infrastructure\ImportServices;

use Cluster\Domain\ClusterCode;
use Cluster\Domain\ClusterRepository;
use DatenImport\Domain\ChariteFaecherAnlegenService;
use DatenImport\Domain\ChariteLernzielFachPersistenzService;
use DatenImport\Domain\LernzielFachRepository;
use DatenImport\Infrastructure\Persistence\ChariteLernzielFachEinleseCSVService;
use Studi\Domain\StudiInternRepository;
use Tests\Integration\Common\DbRepoTestCase;

class LernzielFachPersistenzServiceTest extends DbRepoTestCase
{
    protected $dbRepoInterface = StudiInternRepository::class;

    /**
     * @param ClusterRepository $clusterRepository
     * @param LernzielFachRepository $lernzielFachRepository
     * @return array
     */
    public static function createLernzielFaecher(
        ClusterRepository $clusterRepository,
        LernzielFachRepository $lernzielFachRepository
    ): array {
        $csvImportService = new ChariteLernzielFachEinleseCSVService();
        $service = new ChariteLernzielFachPersistenzService(
            $lernzielFachRepository,
            $clusterRepository
        );

        $data = $csvImportService->getData(
            __DIR__ . "/LEVELUP-Lernziel-Fach.csv",
            ";",
            TRUE,
            "ISO-8859-15"
        );

        $service->persistiereLernzielFaecher($data);

        return $data;
    }

    public function getNeededRepos() {

        return [
            'db-repos' => [
                $this->currentContainer->get(ClusterRepository::class),
                $this->currentContainer->get(LernzielFachRepository::class),
            ],
            //            'file-based-repos' => [
            //                FileBasedSimpleClusterRepository::createTempFileRepo(),
            //                FileBasedSimpleLernzielFachRepository::createTempFileRepo(),
            //            ],
        ];
    }

    /**
     * @dataProvider getNeededRepos
     */
    public function testPersistierePruefung(
        ClusterRepository $clusterRepository,
        LernzielFachRepository $lernzielFachRepository
    ) {
        $this->clearRepos([$clusterRepository, $lernzielFachRepository]);

        (new ChariteFaecherAnlegenService($clusterRepository))->addAlleFaecherZuDB();

        $service = new ChariteLernzielFachPersistenzService(
            $lernzielFachRepository,
            $clusterRepository
        );

        $data = self::createLernzielFaecher($clusterRepository, $lernzielFachRepository);

        $lernzielFaecher = $lernzielFachRepository->all();
        $this->assertCount(349, $lernzielFaecher);
        $cluster = $clusterRepository->byId($lernzielFaecher[0]->getClusterId());
        $this->assertTrue($cluster->getCode()->equals(ClusterCode::fromString("S02")));

        $lernzielFaecher = $lernzielFachRepository->all();
        $service->persistiereLernzielFaecher($data);
        $this->assertCount(349, $lernzielFaecher);
    }

    protected function clearDatabase(): void {

    }

}