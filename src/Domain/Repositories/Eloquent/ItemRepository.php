<?php

namespace ZnBundle\Rbac\Domain\Repositories\Eloquent;

use ZnBundle\Rbac\Domain\Entities\ItemEntity;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnBundle\Rbac\Domain\Interfaces\Repositories\ItemRepositoryInterface;

class ItemRepository extends BaseEloquentCrudRepository implements ItemRepositoryInterface
{

    protected $primaryKey = ['name'];

    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    public function tableName() : string
    {
        return 'auth_item';
    }

    public function getEntityClass() : string
    {
        return ItemEntity::class;
    }
}
