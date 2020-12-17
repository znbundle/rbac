<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace ZnBundle\Rbac\Domain\Services;

use ZnBundle\Rbac\Domain\Enums\RbacPermissionEnum;
use ZnBundle\Rbac\Domain\Enums\RbacRoleEnum;
use ZnBundle\User\Domain\Exceptions\UnauthorizedException;
use ZnCore\Base\Exceptions\InvalidArgumentException;
use ZnCore\Base\Exceptions\InvalidValueException;
use ZnCore\Base\Helpers\ClassHelper;
use ZnBundle\Rbac\Domain\Entities\Assignment;
use ZnBundle\Rbac\Domain\Entities\Item;
use ZnBundle\Rbac\Domain\Entities\Permission;
use ZnBundle\Rbac\Domain\Entities\Role;
use ZnBundle\Rbac\Domain\Entities\Rule;
use ZnBundle\Rbac\Domain\Interfaces\ManagerServiceInterface;
use ZnBundle\Rbac\Domain\Interfaces\RepositoryInterface;

class ManagerService implements ManagerServiceInterface
{

    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Set default roles
     * @param string[]|\Closure $roles either array of roles or a callable returning it
     * @throws InvalidArgumentException when $roles is neither array nor Closure
     * @throws InvalidValueException when Closure return is not an array
     * @since 2.0.14
     */
    public function setDefaultRoles($roles)
    {
        $this->repository->setDefaultRoles($roles);
    }

    public function getDefaultRoles()
    {
        return $this->repository->getDefaultRoles();
    }

    public function createRole(string $name): Role
    {
        $role = new Role();
        $role->name = $name;
        return $role;
    }

    public function createPermission(string $name): Permission
    {
        $permission = new Permission();
        $permission->name = $name;
        return $permission;
    }

    public function add(Item $object): bool
    {
        if ($object instanceof Item) {
            if ($object->ruleName && $this->getRule($object->ruleName) === null) {
                $rule = ClassHelper::createObject($object->ruleName);
                $rule->name = $object->ruleName;
                $this->repository->addRule($rule);
            }

            return $this->repository->addItem($object);
        } elseif ($object instanceof Rule) {
            return $this->repository->addRule($object);
        }

        throw new InvalidArgumentException('Adding unsupported object type.');
    }

    public function remove(Item $object): bool
    {
        if ($object instanceof Item) {
            return $this->repository->removeItem($object);
        } elseif ($object instanceof Rule) {
            return $this->repository->removeRule($object);
        }

        throw new InvalidArgumentException('Removing unsupported object type.');
    }

    public function update(string $name, Item $object)
    {
        if ($object instanceof Item) {
            if ($object->ruleName && $this->getRule($object->ruleName) === null) {
                $rule = ClassHelper::createObject($object->ruleName);
                $rule->name = $object->ruleName;
                $this->repository->addRule($rule);
            }

            return $this->repository->updateItem($name, $object);
        } elseif ($object instanceof Rule) {
            return $this->repository->updateRule($name, $object);
        }

        throw new InvalidArgumentException('Updating unsupported object type.');
    }

    public function getRole(string $name): ?Role
    {
        $item = $this->repository->getItem($name);
        return $item instanceof Item && $item->type == Item::TYPE_ROLE ? $item : null;
    }

    public function getPermission(string $name): ?Permission
    {
        $item = $this->repository->getItem($name);
        return $item instanceof Item && $item->type == Item::TYPE_PERMISSION ? $item : null;
    }

    public function getPermissions(): array
    {
        return $this->repository->getItems(Item::TYPE_PERMISSION);
    }

    public function getRoles(): array
    {
        return $this->repository->getItems(Item::TYPE_ROLE);
    }

    public function getRolesByUser(int $userId): array
    {
        return $this->repository->getRolesByUser($userId);
    }

    public function getChildRoles(string $roleName): array
    {
        return $this->repository->getChildRoles($roleName);
    }

    public function getPermissionsByRole(string $roleName): array
    {
        return $this->repository->getPermissionsByRole($roleName);
    }

    public function getPermissionsByUser(int $userId): array
    {
        return $this->repository->getPermissionsByUser($userId);
    }

    public function getRule(string $name): ?Rule
    {
        return $this->repository->getRule($name);
    }

    public function getRules(): array
    {
        return $this->repository->getRules();
    }

    public function canAddChild(Item $parent, Item $child): bool
    {
        return $this->repository->canAddChild($parent, $child);
    }

    public function addChild(Item $parent, Item $child): bool
    {
        return $this->repository->addChild($parent, $child);
    }

    public function removeChild(Item $parent, Item $child): bool
    {
        return $this->repository->removeChild($parent, $child);
    }

    public function removeChildren(Item $parent): bool
    {
        return $this->repository->removeChildren($parent);
    }

    public function hasChild(Item $parent, Item $child): bool
    {
        return $this->repository->hasChild($parent, $child);
    }

    public function getChildren(string $name): array
    {
        return $this->repository->getChildren($name);
    }

    public function assign(Item $role, int $userId): Assignment
    {
        return $this->repository->assign($role, $userId);
    }

    public function revoke(Item $role, int $userId): bool
    {
        return $this->repository->revoke($role, $userId);
    }

    public function revokeAll($userId): bool
    {
        return $this->repository->revokeAll($userId);
    }

    public function getAssignment(string $roleName, int $userId): ?Assignment
    {
        return $this->repository->getAssignment($roleName, $userId);
    }

    public function getAssignments(?int $userId): array
    {
        /*if ($userId == null) {
            dd($this->repository->getPermissionsByRole('?'));
            $assignments = [];
            $assignment = new Assignment();
            $assignment->roleName = RbacPermissionEnum::GUEST;
            $assignments[RbacPermissionEnum::GUEST] = $assignment;
            return $assignments;
        }*/
        return $this->repository->getAssignments($userId);
    }

    public function getUserIdsByRole(string $roleName): array
    {
        return $this->repository->getUserIdsByRole($roleName);
    }

    public function removeAll()
    {
        return $this->repository->removeAll();
    }

    public function removeAllPermissions()
    {
        return $this->repository->removeAllPermissions();
    }

    public function removeAllRoles()
    {
        return $this->repository->removeAllRoles();
    }

    public function removeAllRules()
    {
        return $this->repository->removeAllRules();
    }

    public function removeAllAssignments()
    {
        return $this->repository->removeAllAssignments();
    }

    public function checkAccess(?int $userId, string $permissionName, array $params = [])
    {
        /*$assignments = $this->getAssignments($userId);
        if(in_array($permissionName, $assignments)) {
            dd($permissionName);
        }*/
        if ($permissionName == RbacRoleEnum::GUEST) {
            return true;
        }
        if ($permissionName == RbacRoleEnum::AUTHORIZED && !empty($userId)) {
            return true;
        }
        return $this->repository->checkAccess($userId, $permissionName, $params);
    }
}
