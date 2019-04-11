<?php

namespace Tests\Integration\Common;

use Common\Domain\DDDRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class DbRepoTestCase extends KernelTestCase
{
    /** @var DDDRepository */
    protected $dbRepo;

    protected $currentContainer;

    protected $dbRepoInterface;

    public function __construct(?string $name = NULL, array $data = [], string $dataName = '') {
        parent::__construct($name, $data, $dataName);
        if ($name !== "containerAlreadyPresent") {
            $kernel = self::bootKernel();
            $this->currentContainer = $kernel->getContainer();
        }
        $this->setDbRepo();
    }

    /** @return static */
    public static function createWithContainer($container) : object {
        $object = new static("containerAlreadyPresent");
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

    public function setUp() : void {
        $this->clearDatabase();
    }

    abstract protected function clearDatabase() : void;

    protected function deleteIdsFromDB($idsToDelete): void {
        foreach ($idsToDelete as $idToDelete) {
            $entity = $this->dbRepo->byId($idToDelete);
            if ($entity) {
                $this->dbRepo->delete($entity);
                $this->dbRepo->flush();
            }

        }
    }

    protected function emptyRepositoryWithTruncate() : void {
        $connection = $this->getDoctrineEntityManager()->getConnection();
        $platform = $connection->getDatabasePlatform();
        $truncateSql = $platform->getTruncateTableSQL($this->getTableName()) . ";";
        $this->executeSQL($truncateSql);
    }

    protected function emptyRepoTableWithDelete() : void {
        $tableName = $this->getTableName();
        $this->emptyTableWithDeleteByName($tableName);
    }

    protected function emptyTableWithDeleteByName($tableName) : void {
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
            $entityManager->refresh($entity);
        }
    }

    private function executeSQL($sql) : void {
        $connection = $this->getDoctrineEntityManager()->getConnection();
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        $connection->executeUpdate($sql);
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');

    }

}