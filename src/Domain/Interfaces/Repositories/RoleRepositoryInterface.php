<?php

namespace ZnBundle\Rbac\Domain\Interfaces\Repositories;

use ZnBundle\Rbac\Domain\Entities\RoleEntity;
use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;
use ZnCore\Domain\Libs\Query;

interface RoleRepositoryInterface extends ItemRepositoryInterface
{

    public function oneByName(string $name, Query $query = null): RoleEntity;
}
