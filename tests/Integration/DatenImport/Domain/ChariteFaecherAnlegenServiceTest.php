<?php

namespace Tests\Integration\DatenImport\Domain\ImportServices;

use Cluster\Domain\ClusterRepository;
use Cluster\Infrastructure\Persistence\Filesystem\FileBasedSimpleClusterRepository;
use DatenImport\Domain\ChariteFaecherAnlegenService;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Tests\Integration\Common\DbRepoTestCase;

class ChariteFaecherAnlegenServiceTest extends DbRepoTestCase
{
    protected $dbRepoInterface = ClusterRepository::class;

    public function getNeededRepo() {
        return [
            'file-based-repo' => [FileBasedSimpleClusterRepository::createTempFileRepo()],
            'db-repo'         => [$this->currentContainer->get(ClusterRepository::class)],
        ];
    }

    /**
     * @dataProvider getNeededRepo
     */
    public function testGetCSVData(ClusterRepository $clusterRepository) {

        $fachImportService = new ChariteFaecherAnlegenService($clusterRepository);
        $fachImportService->addAlleFaecherZuDB();
        $alleFaecher = $clusterRepository->all();

        $this->assertCount(29, $alleFaecher);

    }

    protected function clearDatabase(): void {
        $this->emptyRepositoryWithTruncate();
    }
}