<?php

namespace Common\Infrastructure\Persistence\DB;

use Doctrine\ORM\Query\ResultSetMapping;

trait DoctrineAutoIncrementTrait
{
    protected function getAndIncreaseAutoIncrement(): int {
        return $this->getAndIncreaseAutoIncrementOfTable($this->getTableNameOfRepo());
    }

    protected function getAndIncreaseAutoIncrementOfTable(string $tableName): int {
        $this->entityManager->beginTransaction();

        $dbName = $this->entityManager->getConnection()->getDatabase();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("AUTO_INCREMENT", "AUTO_INCREMENT", "integer");
        $sql = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES"
            . " WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$tableName'";

        $maxId = $this->entityManager->createNativeQuery($sql, $rsm)->getResult()[0]["AUTO_INCREMENT"];
        $maxId = max([1, $maxId]);

        $sql = "ALTER TABLE $tableName AUTO_INCREMENT = " . ($maxId + 1);
        $this->entityManager->getConnection()->executeUpdate($sql);

        $this->entityManager->commit();

        return $maxId;
    }

    protected function getTableNameOfRepo(): string {
        $className = $this->doctrineRepo->getClassName();

        return $this->entityManager->getClassMetadata($className)->getTableName();

    }
}