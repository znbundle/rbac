<?php

namespace ZnBundle\Rbac\Domain\Services;

use ZnBundle\Rbac\Domain\Interfaces\Services\RoleServiceInterface;
use ZnBundle\Rbac\Domain\Interfaces\Repositories\RoleRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;

class RoleService extends BaseCrudService implements RoleServiceInterface
{

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
