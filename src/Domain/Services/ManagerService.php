<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace ZnBundle\Rbac\Domain\Services;

use ZnBundle\Rbac\Domain\Entities\Assignment;
use ZnBundle\Rbac\Domain\Entities\Item;
use ZnBundle\Rbac\Domain\Entities\Permission;
use ZnBundle\Rbac\Domain\Entities\Role;
use ZnBundle\Rbac\Domain\Entities\Rule;
use ZnBundle\Rbac\Domain\Enums\RbacRoleEnum;
use ZnBundle\Rbac\Domain\Interfaces\CanInterface;
use ZnBundle\Rbac\Domain\Interfaces\ManagerServiceInterface;
use ZnBundle\Rbac\Domain\Interfaces\RepositoryInterface;
use ZnBundle\User\Domain\Entities\AssignmentEntity;
use ZnBundle\User\Domain\Repositories\Eloquent\AssignmentRepository;
use ZnCore\Base\Exceptions\ForbiddenException;
use ZnCore\Base\Exceptions\InvalidArgumentException;
use ZnCore\Base\Exceptions\InvalidValueException;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Domain\Entities\Query\Where;
use ZnCore\Domain\Libs\Query;
use ZnCore\Domain\Traits\RepositoryAwareTrait;

class ManagerService implements ManagerServiceInterface, CanInterface
{

    use RepositoryAwareTrait;

    private $assignmentRepository;

    public function __construct(RepositoryInterface $repository, AssignmentRepository $assignmentRepository)
    {
        $this->setRepository($repository);
        $this->assignmentRepository = $assignmentRepository;
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
        $this->getRepository()->setDefaultRoles($roles);
    }

    public function getDefaultRoles()
    {
        return $this->getRepository()->getDefaultRoles();
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
                $this->getRepository()->addRule($rule);
            }

            return $this->getRepository()->addItem($object);
        } elseif ($object instanceof Rule) {
            return $this->getRepository()->addRule($object);
        }

        throw new InvalidArgumentException('Adding unsupported object type.');
    }

    public function remove(Item $object): bool
    {
        if ($object instanceof Item) {
            return $this->getRepository()->removeItem($object);
        } elseif ($object instanceof Rule) {
            return $this->getRepository()->removeRule($object);
        }

        throw new InvalidArgumentException('Removing unsupported object type.');
    }

    public function update(string $name, Item $object)
    {
        if ($object instanceof Item) {
            if ($object->ruleName && $this->getRule($object->ruleName) === null) {
                $rule = ClassHelper::createObject($object->ruleName);
                $rule->name = $object->ruleName;
                $this->getRepository()->addRule($rule);
            }

            return $this->getRepository()->updateItem($name, $object);
        } elseif ($object instanceof Rule) {
            return $this->getRepository()->updateRule($name, $object);
        }

        throw new InvalidArgumentException('Updating unsupported object type.');
    }

    public function getRole(string $name): ?Role
    {
        $item = $this->getRepository()->getItem($name);
        return $item instanceof Item && $item->type == Item::TYPE_ROLE ? $item : null;
    }

    public function getPermission(string $name): ?Permission
    {
        $item = $this->getRepository()->getItem($name);
        return $item instanceof Item && $item->type == Item::TYPE_PERMISSION ? $item : null;
    }

    public function getPermissions(): array
    {
        return $this->getRepository()->getItems(Item::TYPE_PERMISSION);
    }

    public function getRoles(): array
    {
        return $this->getRepository()->getItems(Item::TYPE_ROLE);
    }

    public function getRolesByUser(int $userId): array
    {
        return $this->getRepository()->getRolesByUser($userId);
    }

    public function getChildRoles(string $roleName): array
    {
        return $this->getRepository()->getChildRoles($roleName);
    }

    public function getPermissionsByRole(string $roleName): array
    {
        return $this->getRepository()->getPermissionsByRole($roleName);
    }

    public function getPermissionsByUser(int $userId): array
    {
        return $this->getRepository()->getPermissionsByUser($userId);
    }

    public function getRule(string $name): ?Rule
    {
        return $this->getRepository()->getRule($name);
    }

    public function getRules(): array
    {
        return $this->getRepository()->getRules();
    }

    public function canAddChild(Item $parent, Item $child): bool
    {
        return $this->getRepository()->canAddChild($parent, $child);
    }

    public function addChild(Item $parent, Item $child): bool
    {
        return $this->getRepository()->addChild($parent, $child);
    }

    public function removeChild(Item $parent, Item $child): bool
    {
        return $this->getRepository()->removeChild($parent, $child);
    }

    public function removeChildren(Item $parent): bool
    {
        return $this->getRepository()->removeChildren($parent);
    }

    public function hasChild(Item $parent, Item $child): bool
    {
        return $this->getRepository()->hasChild($parent, $child);
    }

    public function getChildren(string $name): array
    {
        return $this->getRepository()->getChildren($name);
    }

    public function assign(Item $role, int $userId): Assignment
    {
        return $this->getRepository()->assign($role, $userId);
    }

    public function revoke(Item $role, int $userId): bool
    {
        return $this->getRepository()->revoke($role, $userId);
    }

    public function revokeAll($userId): bool
    {
        return $this->getRepository()->revokeAll($userId);
    }

    public function getAssignment(string $roleName, int $userId): ?Assignment
    {
        return $this->getRepository()->getAssignment($roleName, $userId);
    }

    public function getAssignments(?int $userId): array
    {
        /*if ($userId == null) {
            dd($this->getRepository()->getPermissionsByRole('?'));
            $assignments = [];
            $assignment = new Assignment();
            $assignment->roleName = RbacPermissionEnum::GUEST;
            $assignments[RbacPermissionEnum::GUEST] = $assignment;
            return $assignments;
        }*/
        $query = new Query();
        $query->whereNew(new Where('user_id', $userId));
        $assignmentCollection = $this->assignmentRepository->all($query);
        $assignments = [];
        /** @var AssignmentEntity $item */
        foreach ($assignmentCollection as $item) {
            $assignment = new Assignment();
            $assignment->userId = $item->getUserId();
            $assignment->roleName = $item->getItemName();
            $assignments[$assignment->roleName] = $assignment;
        }
        return $assignments;
//        return $this->getRepository()->getAssignments($userId);
    }

    public function getUserIdsByRole(string $roleName): array
    {
        return $this->getRepository()->getUserIdsByRole($roleName);
    }

    public function removeAll()
    {
        return $this->getRepository()->removeAll();
    }

    public function removeAllPermissions()
    {
        return $this->getRepository()->removeAllPermissions();
    }

    public function removeAllRoles()
    {
        return $this->getRepository()->removeAllRoles();
    }

    public function removeAllRules()
    {
        return $this->getRepository()->removeAllRules();
    }

    public function removeAllAssignments()
    {
        return $this->getRepository()->removeAllAssignments();
    }

    public function isCan(?int $userId, array $permissions, array $params = []): bool
    {
        foreach ($permissions as $permission) {
            $isCan = $this->checkAccess($userId, $permission);
            if (!$isCan) {
                return false;
            }
        }
        return true;
    }

    public function can(?int $userId, array $permissions, array $params = []): void
    {
        $isCan = $this->isCan($userId, $permissions);
        if (!$isCan) {
            throw new ForbiddenException('Forbidden');
        }
    }

    public function checkAccess(?int $userId, string $permissionName, array $params = [])
    {
        $assignments = $this->getAssignments($userId);
        /*if(in_array($permissionName, $assignments)) {
            dd($permissionName);
        }*/
        if ($permissionName == RbacRoleEnum::GUEST) {
            return true;
        }
        if ($permissionName == RbacRoleEnum::AUTHORIZED && !empty($userId)) {
            return true;
        }
        $isAllow = $this->getRepository()->checkAccessByAssignments($userId, $permissionName, $params, $assignments);
        return $isAllow;




//        $isAllow = $this->getRepository()->checkAccessFromCache($userId, $permissionName, $params, $assignments);
//        return $isAllow;

//        Bot::dump($rr);

//        return $this->getRepository()->checkAccess($userId, $permissionName, $params);
    }
}
