<?php

namespace Tests\Integration\Common;

use Common\Domain\DDDRepository;
use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class DbRepoTestCase extends KernelTestCase
{
    /** @var DDDDoctrineRepoTrait */
    protected $dbRepo;

    public function getDbRepo(): DDDRepository {
        return $this->dbRepo;
    }

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

    public static function createWithContainer($container) {
        $object = new static("containerAlreadyPresent");
        $object->currentContainer = $container;
        $object->setDbRepo();
        return $object;
    }

    protected function setDbRepo(): void {
        if ($this->currentContainer) {
            $this->dbRepo = $this->currentContainer->get($this->dbRepoInterface);
        }
    }

    public function setUp() {
        $this->clearDatabase();
    }

    abstract protected function clearDatabase();


    protected function deleteIdsFromDB($idsToDelete): void {
        foreach ($idsToDelete as $idToDelete) {
            $entity = $this->dbRepo->byId($idToDelete);
            if ($entity) {
                $this->dbRepo->delete($entity);
                $this->dbRepo->flush();
            }

        }
    }

    protected function emptyRepository() {

        $ref = new \ReflectionObject($this->dbRepo);
        /** @var EntityManagerInterface $em */
        $entityManagerRef = $ref->getProperty('entityManager');
        $doctrineRepoRef = $ref->getProperty('doctrineRepo');
        $entityManagerRef->setAccessible(true);
        $doctrineRepoRef->setAccessible(true);

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $entityManagerRef->getValue($this->dbRepo);
        /** @var EntityRepository $doctrineRepo */
        $doctrineRepo = $doctrineRepoRef->getValue($this->dbRepo);
        $connection = $entityManager->getConnection();

        $platform = $connection->getDatabasePlatform();
        $tableName = $entityManager->getClassMetadata($doctrineRepo->getClassName())->getTableName();
        $truncateSql = $platform->getTruncateTableSQL($tableName) . ";";
        $this->executeSQL($truncateSql);
    }

    protected function emptyTable($tableName) {
        $sql = "DELETE FROM `$tableName`";
        $this->executeSQL($sql);
    }

    private function executeSQL($sql) {
        $ref = new \ReflectionObject($this->dbRepo);
        /** @var EntityManagerInterface $em */
        $entityManagerRef = $ref->getProperty('entityManager');
        $doctrineRepoRef = $ref->getProperty('doctrineRepo');
        $entityManagerRef->setAccessible(true);
        $doctrineRepoRef->setAccessible(true);

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $entityManagerRef->getValue($this->dbRepo);
        /** @var EntityRepository $doctrineRepo */
        $connection = $entityManager->getConnection();

        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        $connection->executeUpdate($sql);
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');

    }


}