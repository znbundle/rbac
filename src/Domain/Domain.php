<?php

namespace ZnBundle\Rbac\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'rbac';
    }


}

