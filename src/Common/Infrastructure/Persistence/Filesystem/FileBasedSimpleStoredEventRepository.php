<?php

namespace Common\Infrastructure\Persistence\Filesystem;

use Common\Infrastructure\Persistence\Common\AbstractSimpleStoredEventRepository;
use Common\Infrastructure\Persistence\Common\FileBasedRepoTrait;

final class FileBasedSimpleStoredEventRepository extends AbstractSimpleStoredEventRepository
{
    use FileBasedRepoTrait;
}
