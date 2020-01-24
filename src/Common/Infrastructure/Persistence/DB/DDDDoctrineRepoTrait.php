<?php

namespace Common\Infrastructure\Persistence\DB;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

trait DDDDoctrineRepoTrait
{
    use DoctrineAutoIncrementTrait;
    use DoctrineFlushTrait;

    protected \Doctrine\ORM\EntityRepository $doctrineRepo;

    protected \Doctrine\ORM\EntityManagerInterface $entityManager;

    public function __construct(EntityRepository $doctrineRepo, EntityManagerInterface $entityManager) {
        $this->doctrineRepo = $doctrineRepo;
        $this->entityManager = $entityManager;
    }

    public function all(): array {
        return $this->doctrineRepo->findAll();
    }

    private function abstractAdd($object): void {
        $this->entityManager->persist($object);
    }

    private function abstractById($objectId): ?object {
        return $this->doctrineRepo->find($objectId);
    }

    private function abstractDelete(object $object): void {
        $this->entityManager->remove($object);
    }

    private function abstractNextIdentityAsInt(): int {
        return $this->getAndIncreaseAutoIncrement();
    }

}