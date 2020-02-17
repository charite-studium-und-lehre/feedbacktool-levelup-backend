<?php

namespace Common\Infrastructure\Persistence\DB;

use Common\Domain\TableAutoIncrement;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;

/** @property EntityManager $entityManager */
trait DoctrineAutoIncrementTrait
{
    protected function getAndIncreaseAutoIncrement(): int {
        return $this->getAndIncreaseAutoIncrementOfTable();
    }

    private function getAndIncreaseAutoIncrementOfTable(): int {
        $this->entityManager->beginTransaction();
        $tableName = $this->getTableNameOfRepo();

        // Lesen-Schreiben-Lesen um race conditions zu verhindern.
        $ai = $this->getCurrentAutoIncrement($tableName);
        if (!$ai) {
            $this->createAutoIncrement($tableName);
            $ai = $this->getCurrentAutoIncrement($tableName);
        }
        $this->increaseAutoIncrement($tableName);
        $this->entityManager->commit();

        return $ai;
    }

    private function getTableNameOfRepo(): string {
        $className = $this->doctrineRepo->getClassName();

        return $this->entityManager->getClassMetadata($className)->getTableName();
    }

    private function getCurrentAutoIncrement(string $tableName): int {
        /** @var TableAutoIncrement $currentAiObject */
        $currentAiObject = $this->entityManager->getRepository(TableAutoIncrement::class)
            ->find($tableName);
        if ($currentAiObject === NULL) {
            return 0;
        }
        $this->entityManager->refresh($currentAiObject);

        return $currentAiObject->getAutoIncrement();
    }

    private function getDbAutoIncrement(string $tableName): int {
        $dbName = $this->entityManager->getConnection()->getDatabase();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("AUTO_INCREMENT", "AUTO_INCREMENT", "integer");
        $sql = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES
             WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$tableName'";

        $result = $this->entityManager->createNativeQuery($sql, $rsm)->getResult();
        if (!$result) {
            return 1;
        }

        return max($result[0]["AUTO_INCREMENT"], 1);
    }

    private function getMaxIdFromDb(string $tableName): int {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("maxId", "maxId", "integer");
        $sql = "SELECT MAX(id) AS maxId FROM `$tableName`";

        $result = $this->entityManager->createNativeQuery($sql, $rsm)->getResult();
        if (!$result) {
            return 0;
        }

        return max((int) $result[0]["maxId"], 0);
    }


    private function createAutoIncrement(string $tableName): void {
        $nextAIFromDB = $this->getDbAutoIncrement($tableName);
        $maxIdFromTable = $this->getMaxIdFromDb($tableName);
        $aiFromDb = max($nextAIFromDB, $maxIdFromTable + 1);
        $aiObject = new TableAutoIncrement($tableName, $aiFromDb);
        $this->entityManager->persist($aiObject);
        $this->entityManager->flush();
    }

    private function increaseAutoIncrement(string $tableName): void {
        $sql =
            "UPDATE `__tableAutoIncrement` SET `autoIncrement` = `autoIncrement` + 1 WHERE `tableName` = '$tableName'";
        $this->entityManager->getConnection()->executeUpdate($sql);
    }
}