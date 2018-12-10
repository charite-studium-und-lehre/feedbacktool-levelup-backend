<?php

namespace Common\Infrastructure\Persistence\DB;

use Common\Application\AbstractEvent\StoredEvent;
use Common\Application\AbstractEvent\StoredEventId;
use Common\Application\AbstractEvent\StoredEventRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

final class DBStoredEventRepository implements StoredEventRepository
{
    use DoctrineAutoIncrementTrait;
    use DoctrineFlushTrait;

    /** @var ServiceEntityRepository */
    private $doctrineRepo;

    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityRepository $doctrineRepo, EntityManager $entityManager) {
        $this->doctrineRepo = $doctrineRepo;
        $this->entityManager = $entityManager;
    }

    public function all(): array {
        return $this->doctrineRepo->findAll();
    }

    public function delete(StoredEvent $object): void {
        $this->entityManager->remove($object);
    }

    public function add(StoredEvent $object): void {
        $this->entityManager->persist($object);
    }

    public function byId(StoredEventId $id): ?StoredEvent {
        return $this->doctrineRepo->find($id->getValue());
    }

    public function nextIdentity(): StoredEventId {
        return StoredEventId::fromInt($this->getAndIncreaseAutoIncrement());
    }

}