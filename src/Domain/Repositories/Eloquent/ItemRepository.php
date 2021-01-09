<?php

namespace ZnBundle\Rbac\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use Packages\Eav\Domain\Entities\EntityAttributeEntity;
use Packages\Eav\Domain\Entities\EntityEntity;
use Packages\Eav\Domain\Interfaces\Repositories\EntityAttributeRepositoryInterface;
use ZnBundle\Rbac\Domain\Entities\ItemEntity;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Relations\relations\OneToManyRelation;
use ZnCore\Domain\Relations\relations\VoidRelation;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnBundle\Rbac\Domain\Interfaces\Repositories\ItemRepositoryInterface;

class ItemRepository extends BaseEloquentCrudRepository implements ItemRepositoryInterface
{

    /*protected $primaryKey = ['name'];

    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }*/

    public function tableName() : string
    {
        return 'auth_item';
    }

    public function getEntityClass() : string
    {
        return ItemEntity::class;
    }

    public function relations2()
    {
        return [
            [
                'class' => VoidRelation::class,
                'name' => 'children',
                'prepareCollection' => function (Collection $collection) {

                    dd($collection);
                    return $collection;
                }
            ],
        ];
    }
}
