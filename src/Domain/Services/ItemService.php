<?php

namespace ZnBundle\Rbac\Domain\Services;

use ZnBundle\Rbac\Domain\Interfaces\ManagerServiceInterface;
use ZnBundle\Rbac\Domain\Interfaces\Services\ItemServiceInterface;
use ZnBundle\Rbac\Domain\Interfaces\Repositories\ItemRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Helpers\EntityHelper;

class ItemService extends BaseCrudService implements ItemServiceInterface
{

    protected $managerService;

    public function __construct(ItemRepositoryInterface $repository, ManagerServiceInterface $managerService)
    {
        $this->setRepository($repository);
        $this->managerService = $managerService;
    }

    public function deleteById($id)
    {
        $entity = $this->oneById($id);
        $this->managerService->remove($entity);
    }

    public function updateById($id, $data)
    {
        $entity = $this->oneById($id);
        EntityHelper::setAttributes($entity, $data, [
            'type',
            'description',
            'rule_name',
        ]);
        $this->managerService->update($entity->name, $entity);
    }
}
