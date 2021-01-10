<?php

namespace ZnBundle\Rbac\Domain\Repositories\Eloquent;

use ZnBundle\Rbac\Domain\Entities\ItemEntity;
use ZnBundle\Rbac\Domain\Entities\Role;
use ZnBundle\Rbac\Domain\Entities\RoleEntity;
use ZnBundle\Rbac\Domain\Interfaces\Repositories\RoleRepositoryInterface;
use ZnCore\Domain\Entities\Query\Where;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Libs\Query;

class RoleRepository extends ItemRepository implements RoleRepositoryInterface
{

    public function getEntityClass(): string
    {
        return RoleEntity::class;
    }

    protected function forgeQuery(Query $query = null)
    {
        $query = parent::forgeQuery($query);
        $query->whereNew(new Where('type', ItemEntity::TYPE_ROLE));
        return $query;
    }

    public function oneByName(string $name, Query $query = null): RoleEntity
    {
        $query = $this->forgeQuery($query);
        $query->whereNew(new Where('name', $name));
        return parent::one($query);
    }
}
