<?php

namespace ZnBundle\Rbac\Domain\Repositories\Eloquent;

use ZnBundle\Rbac\Domain\Entities\ItemEntity;
use ZnBundle\Rbac\Domain\Entities\RoleEntity;
use ZnBundle\Rbac\Domain\Interfaces\Repositories\RoleRepositoryInterface;
use ZnCore\Domain\Entities\Query\Where;
use ZnCore\Domain\Libs\Query;

class RoleRepository extends ItemRepository implements RoleRepositoryInterface
{

    protected function forgeQuery(Query $query = null)
    {
        $query = parent::forgeQuery($query);
        $query->whereNew(new Where('type', ItemEntity::TYPE_ROLE));
        return $query;
    }
}
