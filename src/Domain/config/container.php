<?php

return [
    'singletons' => [
        'ZnBundle\Rbac\Domain\Interfaces\Services\RoleServiceInterface' => 'ZnBundle\Rbac\Domain\Services\RoleService',
        'ZnBundle\Rbac\Domain\Interfaces\Services\ItemServiceInterface' => 'ZnBundle\Rbac\Domain\Services\ItemService',

        'ZnBundle\Rbac\Domain\Interfaces\Repositories\RoleRepositoryInterface' => 'ZnBundle\Rbac\Domain\Repositories\Eloquent\RoleRepository',
        'ZnBundle\Rbac\Domain\Interfaces\Repositories\ItemRepositoryInterface' => 'ZnBundle\Rbac\Domain\Repositories\Eloquent\ItemRepository',
    ],
];