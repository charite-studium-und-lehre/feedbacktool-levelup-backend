<?php

namespace Studi\Domain;


use Common\Domain\DDDRepository;
use Common\Domain\FlushableRepository;

interface PersonRepository extends DDDRepository, FlushableRepository
{
    public function add(Person $object): void;

    public function byId(PersonId $id): ?Person;

    /** @return Person[] */
    public function getAll(): array;

    public function delete(Person $object): void;

    public function nextIdentity(): PersonId;
}
