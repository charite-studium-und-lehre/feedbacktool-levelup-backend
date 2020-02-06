<?php

namespace Common\Infrastructure\Persistence\Common;

use Common\Domain\DDDEntity;

trait FileBasedRepoTrait
{
    protected string $filePath;

    public function __construct(string $filePath) {
        $this->filePath = $filePath;
    }

    /** @return static */
    public static function createTempFileRepo() {
        return new static(tempnam(sys_get_temp_dir(), static::class));
    }

    /** @return static */
    public static function createFixedFileRepo(string $fileSuffix) {
        return new static(sys_get_temp_dir() . DIRECTORY_SEPARATOR . static::class . $fileSuffix);
    }

    public function all(): array {
        if (!$this->persistedEntities) {

            if (!file_exists($this->filePath)) {
                $this->persistedEntities = [];
            } else {
                $rawJson = file_get_contents($this->filePath);
                if (empty($rawJson)) {
                    $this->persistedEntities = [];
                } else {
                    $this->persistedEntities = unserialize($rawJson);
                }
            }
        }

        return $this->persistedEntities;
    }

    public function persistEntities(array $entities): void {
        $this->persistedEntities = $entities;
        if (!is_dir(dirname($this->filePath))) {
            mkdir(dirname($this->filePath), 0777, TRUE);
        }
        file_put_contents($this->filePath, serialize($entities));
    }

    public function clearRepo(): void {
        file_put_contents($this->filePath, "");
        $this->persistedEntities = NULL;
    }
}
