<?php

namespace Tests\Integration\Common;

use Common\Domain\DDDRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiIntern;
use Studi\Domain\StudiInternRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class DbRepoTestCase extends KernelTestCase
{
    const CONTAINER_ALREADY_PRESENT = "containerAlreadyPresent";

    /** @var DDDRepository */
    protected $dbRepo;

    protected $currentContainer;

    protected $dbRepoInterface;

    public function __construct(?string $name = NULL, array $data = [], string $dataName = '') {
        parent::__construct($name, $data, $dataName);
        if ($name !== self::CONTAINER_ALREADY_PRESENT) {
            $kernel = self::bootKernel();
            $this->currentContainer = $kernel->getContainer();
        }
        $this->setDbRepo();
    }

    /** @return static */
    public static function createWithContainer($container): object {
        $object = new static(self::CONTAINER_ALREADY_PRESENT);
        $object->currentContainer = $container;
        $object->setDbRepo();

        return $object;
    }

    public function getDbRepo(): DDDRepository {
        return $this->dbRepo;
    }

    protected function setDbRepo(): void {
        if ($this->currentContainer) {
            $this->dbRepo = $this->currentContainer->get($this->dbRepoInterface);
        }
    }

    public function setUp(): void {
        $this->clearDatabase();
    }

    protected function clearDatabase() {
    }

    protected function deleteIdsFromDB($idsToDelete): void {
        foreach ($idsToDelete as $idToDelete) {
            $entity = $this->dbRepo->byId($idToDelete);
            if ($entity) {
                $this->dbRepo->delete($entity);
                $this->dbRepo->flush();
            }

        }
    }

    protected function emptyRepositoryWithTruncate(): void {
        $connection = $this->getDoctrineEntityManager()->getConnection();
        $platform = $connection->getDatabasePlatform();
        $truncateSql = $platform->getTruncateTableSQL($this->getTableName()) . ";";
        $this->executeSQL($truncateSql);
    }

    protected function emptyRepoTableWithDelete(): void {
        $tableName = $this->getTableName();
        $this->emptyTableWithDeleteByName($tableName);
    }

    protected function emptyTableWithDeleteByName($tableName): void {
        $sql = "DELETE FROM `$tableName`";
        $this->executeSQL($sql);
    }

    protected function getTableName(): string {
        $className = $this->getDoctrineRepository()->getClassName();

        return $this->getDoctrineEntityManager()
            ->getClassMetadata($className)
            ->getTableName();
    }

    /**
     * @throws \ReflectionException
     */
    protected function getDoctrineEntityManager(): EntityManagerInterface {
        $ref = new \ReflectionObject($this->dbRepo);
        $entityManagerRef = $ref->getProperty('entityManager');
        $entityManagerRef->setAccessible(TRUE);

        return $entityManagerRef->getValue($this->dbRepo);
    }

    /**
     * @throws \ReflectionException
     */
    protected function getDoctrineRepository(): EntityRepository {
        $ref = new \ReflectionObject($this->dbRepo);
        $doctrineRepoRef = $ref->getProperty('doctrineRepo');
        $doctrineRepoRef->setAccessible(TRUE);
        $doctrineRepo = $doctrineRepoRef->getValue($this->dbRepo);

        return $doctrineRepo;
    }

    protected function refreshEntities(...$entities) {
        $entityManager = $this->getDoctrineEntityManager();
        foreach ($entities as $entity) {
            $entityManager->persist($entity);
            try {
                $entityManager->refresh($entity);
            } catch (\ErrorException $e) {

            }
        }
    }

    protected function clearRepos($repositories): void {
        if (!is_array($repositories)) {
            $repositories = [$repositories];
        }
        foreach ($repositories as $repo) {
            /** @var DDDRepository $repo */
            foreach ($repo->all() as $object) {
                $repo->delete($object);
            }
            $repo->flush();
        }
    }

    protected function createTestStudis(StudiInternRepository $studiInternRepo): void {

        foreach ($studiInternRepo->all() as $studiIntern) {
            $studiInternRepo->delete($studiIntern);
            $studiInternRepo->flush();
        }
        $studiInternRepo->add(StudiIntern::fromMatrikelUndStudiHash(
            Matrikelnummer::fromInt("222222"),
            StudiHash::fromString('9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08')
        ));
        $studiInternRepo->add(StudiIntern::fromMatrikelUndStudiHash(
            Matrikelnummer::fromInt("444444"),
            StudiHash::fromString('60303ae22b998861bce3b28f33eec1be758a213c86c93c076dbe9f558c11c752')
        ));
        $studiInternRepo->add(StudiIntern::fromMatrikelUndStudiHash(
            Matrikelnummer::fromInt("555555"),
            StudiHash::fromString('7f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08')
        ));

        foreach (range(111111, 111234) as $matrikelnummer) {
            $studiInternRepo->add(StudiIntern::fromMatrikelUndStudiHash(
                Matrikelnummer::fromInt($matrikelnummer),
                StudiHash::fromString('8f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0'
                                      . $matrikelnummer)
            ));

        }

        $studiInternRepo->flush();

    }

    private function executeSQL($sql): void {
        $connection = $this->getDoctrineEntityManager()->getConnection();
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        $connection->executeUpdate($sql);
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');

    }

}