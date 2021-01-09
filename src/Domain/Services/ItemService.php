<?php

namespace ZnBundle\Rbac\Domain\Services;

use ZnBundle\Rbac\Domain\Interfaces\Services\ItemServiceInterface;
use ZnBundle\Rbac\Domain\Interfaces\Repositories\ItemRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;

class ItemService extends BaseCrudService implements ItemServiceInterface
{

    public function __construct(ItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
