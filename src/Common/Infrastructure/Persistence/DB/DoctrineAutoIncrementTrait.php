<?php

namespace Common\Infrastructure\Persistence\DB;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;

/** @property EntityManager $entityManager */
trait DoctrineAutoIncrementTrait
{
    protected function getAndIncreaseAutoIncrement(): int {
        return $this->getAndIncreaseAutoIncrementOfTable();
    }

    protected function getAndIncreaseAutoIncrementOfTable(): int {
        $this->entityManager->beginTransaction();
        $tableName = $this->getTableNameOfRepo();

        // Lesen-Schreiben-Lesen um race conditions zu verhindern.
        $ai1 = $this->getCurrentAutoIncrement($tableName);
        $this->increaseAutoIncrement($tableName);


        $this->entityManager->commit();

        return $ai1;
    }

    protected function getTableNameOfRepo(): string {
        $className = $this->doctrineRepo->getClassName();
        return $this->entityManager->getClassMetadata($className)->getTableName();
    }

    protected function getCurrentAutoIncrement(string $tableName): int {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("AUTO_INCREMENT", "AUTO_INCREMENT", "integer");
        $sql = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES"
            . " WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = '$tableName'";

        $maxId = $this->entityManager->createNativeQuery($sql, $rsm)->getResult()[0]["AUTO_INCREMENT"];
        $maxId = max([1, $maxId]);

        return $maxId;
    }

    protected function increaseAutoIncrement(string $tableName): void {
        $sql =
            "SET @ai = (SELECT `AUTO_INCREMENT` + 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA  = DATABASE() AND TABLE_NAME = '$tableName');"
            . "SET @ai = CONCAT('ALTER TABLE $tableName AUTO_INCREMENT = ', @ai);"
            . "PREPARE stmt FROM @ai ;EXECUTE stmt;";
        $this->entityManager->getConnection()->executeUpdate($sql);
    }
}