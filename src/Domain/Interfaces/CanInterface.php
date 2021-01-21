<?php

namespace ZnBundle\Rbac\Domain\Interfaces;

use ZnCore\Base\Exceptions\ForbiddenException;

interface CanInterface
{

    /**
     * @param int|null $userId
     * @param array $permissions
     * @param array $params
     * @return bool
     */
    public function isCan(?int $userId, array $permissions, array $params = []): bool;

    /**
     * @param int|null $userId
     * @param array $permissions
     * @param array $params
     * @throws ForbiddenException
     */
    public function can(?int $userId, array $permissions, array $params = []): void;
}
