<?php

namespace Studi\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\StudiIntern;
use Studi\Domain\StudiInternRepository;

/**
 * @method byId($objectId)
 */
final class DBStudiInternRepository implements StudiInternRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(StudiIntern $object): void {
        $this->abstractDelete($object);
    }

    public function add(StudiIntern $object): void {
        $this->abstractAdd($object);
    }

    public function byMatrikelnummer(Matrikelnummer $matrikelnummer): ?StudiIntern {
        return $this->abstractById($matrikelnummer->getValue());
    }
}