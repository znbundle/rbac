<?php

namespace ZnBundle\Rbac;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function yiiAdmin(): array
    {
        return [
            'modules' => [
                'rbac' => __NAMESPACE__ . '\Yii2\Admin\Module',
            ],
        ];
    }

    public function i18next(): array
    {
        return [
            'rbac' => 'vendor/znbundle/rbac/src/Domain/i18next/__lng__/__ns__.json',
        ];
    }

    public function migration(): array
    {
        return [
            '/vendor/znbundle/rbac/src/Domain/Migrations',
            //'/vendor/znbundle/rbac/src/Domain/MigrationsFile',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
