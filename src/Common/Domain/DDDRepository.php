<?php

namespace Common\Domain;

/**
 * Interface DDDRepository
 *
 * @package Common\Domain
 * @method delete($object)
 * @method byId($objectId)
 *
 */
interface DDDRepository {
    public function all();
}