<?php

namespace ZnBundle\Rbac\Yii2\Admin\Forms;

use ZnCore\Domain\Helpers\EntityHelper;
use ZnYii\Base\Forms\BaseForm;

class ItemForm extends BaseForm
{

    public $name = null;
    public $description = null;
    public $ruleName = null;
    public $data = null;

    public function i18NextConfig(): array
    {
        return [
            'bundle' => 'rbac',
            'file' => 'item',
        ];
    }

    public function translateAliases(): array
    {
        return [
            //'type_id' => 'type',
        ];
    }

    public function ruleList(): array
    {
        $collection = $this->contactTypeRepository->all();
        return EntityHelper::collectionToArray($collection);
    }
}