<?php

namespace ZnBundle\Rbac\Domain\Enums\Rbac;

use ZnCore\Base\Interfaces\GetLabelsInterface;

class RbacRolePermissionEnum implements GetLabelsInterface
{

    const ALL = 'oRbacRoleAll';
    const ONE = 'oRbacRoleOne';
    const CREATE = 'oRbacRoleCreate';
    const UPDATE = 'oRbacRoleUpdate';
    const DELETE = 'oRbacRoleDelete';
    //const RESTORE = 'oRbacRoleRestore';

    public static function getLabels()
    {
        return [
            self::ALL => 'Роли. Просмотр списка',
            self::ONE => 'Роли. Просмотр записи',
            self::CREATE => 'Роли. Создание',
            self::UPDATE => 'Роли. Редактирование',
            self::DELETE => 'Роли. Удаление',
            //self::RESTORE => 'Роли. Восстановление',
        ];
    }

}