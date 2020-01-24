<?php

namespace Common\Domain;

class TableAutoIncrement
{
    private string $tableName;

    private ?int $autoIncrement;

    public function __construct(string $tableName, int $autoIncrement) {
        $this->tableName = $tableName;
        $this->autoIncrement = $autoIncrement;
    }

    public function getTableName(): string {
        return $this->tableName;
    }

    public function getAutoIncrement(): ?int {
        return $this->autoIncrement;
    }

}