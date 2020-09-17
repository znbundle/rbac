<?php

namespace ZnBundle\Rbac\Domain\Enums;

use ZnCore\Domain\Base\BaseEnum;

class RbacPermissionEnum extends BaseEnum
{

    const MANAGE = 'oRbacManage';
	const AUTHORIZED = '@';
	const GUEST = '?';

    public static function getLabels() {
        return [
            self::MANAGE => 'Управление RBAC',
            self::AUTHORIZED => 'Авторизованный',
            self::GUEST => 'Гость',
        ];
    }

}