<?php

namespace Common\Infrastructure\Persistence\Common;

trait FileBasedRepoTrait
{
    /**
     * @var string
     */
    protected $filePath;

    protected $persistedEntities = NULL;

    public function __construct($filePath) {
        $this->filePath = $filePath;
    }

    public static function createTempFileRepo() {
        return new static(tempnam(sys_get_temp_dir(), static::class));
    }

    public function getAll(): array {
        if ($this->persistedEntities === NULL) {

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

}
