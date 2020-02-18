<?php

namespace Common\Infrastructure\Persistence\Common;

use Common\Domain\AggregateId;
use Common\Domain\AggregateIdString;
use Common\Domain\DDDEntity;

/** @method array all() */
class AbstractCommonRepository
{

    /*** @var DDDEntity[] */
    protected array $persistedEntities = [];

    public function add($entity): void {
        $entities = $this->all();
        $entities[] = $entity;
        $this->persistEntities($entities);
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

    /**
     * @param AggregateId|AggregateIdString $entityId
     * @return ?DDDEntity
     */
    public function abstractById($entityId) {
        foreach ($this->all() as $entity) {
            if ($entity->getId()->equals($entityId)) {
                return $entity;
            }
        }

        return NULL;
    }

    /** @return AggregateId */
    public function abstractNextIdentity(): AggregateId {
        return AggregateId::fromInt(random_int(1, PHP_INT_MAX));
    }

    /**
     * Flush all changed entities already known by Repository
     */
    public function flush(): void {
        $this->persistEntities($this->all());
    }

    /** @param DDDEntity[] $entities */
    protected function persistEntities(array $entities): void {
        $this->persistedEntities = $entities;
    }

}