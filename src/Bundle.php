<?php

namespace ZnBundle\Rbac;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function i18next(): array
    {
        return [
            
        ];
    }

    public function migration(): array
    {
        return [
            '/vendor/znbundle/rbac/src/Domain/MigrationsFile',
        ];
    }

    public function container(): array
    {
        return [
            
        ];
    }
}
