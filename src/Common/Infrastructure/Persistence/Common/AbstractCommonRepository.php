<?php

namespace Common\Infrastructure\Persistence\Common;

use Common\Domain\AggregateId;

class AbstractCommonRepository
{

    public function add($entity): void {
        $entities = $this->all();
        $entities[] = $entity;
        $this->persistEntities($entities);
    }

    protected function persistEntities(array $entities) {
        $this->persistedEntities = $entities;
    }

    public function delete($entity): void {
        $all = $this->all();
        $newArray = [];
        foreach ($all as $object) {
            if (!$object->equals($entity)) {
                $newArray[] = $object;
            }
        }
        $this->persistEntities($newArray);
    }

    public function abstractById($entityId) {
        foreach ($this->all() as $entity) {
            if ($entity->getId()->equals($entityId)) {
                return $entity;
            }
        }

        return NULL;
    }

    public function abstractNextIdentity(): AggregateId {
        return AggregateId::fromInt((int) random_int(1, PHP_INT_MAX));
    }

    /**
     * Flush all changed entities already known by Repository
     */
    public function flush(): void {
        $this->persistEntities($this->all());
    }

}