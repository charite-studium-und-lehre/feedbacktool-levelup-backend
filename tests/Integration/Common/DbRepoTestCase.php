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
    /** @var DDDRepository */
    protected $dbRepo;

    protected $currentContainer;

    protected $dbRepoInterface;

    const CONTAINER_ALREADY_PRESENT = "containerAlreadyPresent";

    public function __construct(?string $name = NULL, array $data = [], string $dataName = '') {
        parent::__construct($name, $data, $dataName);
        if ($name !== self::CONTAINER_ALREADY_PRESENT) {
            $kernel = self::bootKernel();
            $this->currentContainer = $kernel->getContainer();
        }
        $this->setDbRepo();
    }

    /** @return static */
    public static function createWithContainer($container) : object {
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

    public function setUp() : void {
        $this->clearDatabase();
    }

    protected function clearDatabase() {}

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
            try {
                $entityManager->refresh($entity);
            } catch (\ErrorException $e) {

            }
        }
    }

    private function executeSQL($sql) : void {
        $connection = $this->getDoctrineEntityManager()->getConnection();
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        $connection->executeUpdate($sql);
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');

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
        }
        $repo->flush();
    }

    protected function createTestStudis(StudiInternRepository $studiInternRepo): void {

        foreach ($studiInternRepo->all() as $studiIntern) {
            $studiInternRepo->delete($studiIntern);
            $studiInternRepo->flush();
        }
        $studiInternRepo->add(StudiIntern::fromMatrikelUndStudiHash(
            Matrikelnummer::fromInt("222222"),
            StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$SjNFNWJPNXVFTkVoaEEwcQ$xrpCKHbfjfjRLrn0K1keYfk6SCFlGQfWuT7edgpaO8E')
        ));
        $studiInternRepo->add(StudiIntern::fromMatrikelUndStudiHash(
            Matrikelnummer::fromInt("444444"),
            StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$LkhXWG5HRS9hWm1kWWx0VA$qSA8yS4/Zdsm0zeWajL3uw3188zkk/HCPZic0KlweCs')
        ));
        $studiInternRepo->add(StudiIntern::fromMatrikelUndStudiHash(
            Matrikelnummer::fromInt("555555"),
            StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$anh4WFZZc3VDdExCdEMzdg$Zfy1+698erxOxiqG0RhUqiZ7uHt59nrR9llJMlsJXOY')
        ));

        foreach (range(111111, 111234) as $matrikelnummer) {
            $studiInternRepo->add(StudiIntern::fromMatrikelUndStudiHash(
                Matrikelnummer::fromInt($matrikelnummer),
                StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$SjNFNWJPNXVFTkVoaEEwcQ$xrpCKHbfjfjRLrn0K1keYfk6SCFlGQfWuT7ed'
                                      . $matrikelnummer)
            ));

        }

        $studiInternRepo->flush();

    }

}