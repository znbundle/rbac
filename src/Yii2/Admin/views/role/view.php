<?php

/**
 * @var View $this
 * @var Request $request
 * @var RoleEntity $entity
 */

use yii\helpers\Url;
use yii\web\Request;
use yii\web\View;
use ZnBundle\Rbac\Domain\Entities\RoleEntity;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnLib\Web\Widgets\Detail\DetailWidget;

$this->title = $entity->getTitle();

$attributes = [
    [
        'label' => 'ID',
        'attributeName' => 'id',
    ],
    [
        'label' => I18Next::t('rbac', 'item.attribute.name'),
        'attributeName' => 'name',
    ],
    [
        'label' => I18Next::t('rbac', 'item.attribute.description'),
        'attributeName' => 'description',
    ],
    [
        'label' => I18Next::t('rbac', 'item.attribute.ruleName'),
        'attributeName' => 'ruleName',
    ],
    [
        'label' => I18Next::t('rbac', 'item.attribute.data'),
        'attributeName' => 'data',
    ],
];

?>

<div class="row">

    <div class="col-lg-12">

        <?= DetailWidget::widget([
            'entity' => $entity,
            'attributes' => $attributes,
        ]) ?>

        <div class="float-left">
            <a href="<?= Url::to(['/rbac/role/update', 'id' => $entity->getId()]) ?>"
               class="btn btn-primary">
                <i class="fa fa fa-edit"></i>
                <?= I18Next::t('core', 'action.update') ?>
            </a>
            <a href="<?= Url::to(['/rbac/role/delete', 'id' => $entity->getId()]) ?>"
               class="btn btn-danger" data-method="post"
               data-confirm="<?= I18Next::t('web', 'message.delete_confirm') ?>">
                <i class="fa fa-trash"></i>
                <?= I18Next::t('core', 'action.delete') ?>
            </a>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-lg-12">
        <h3 class="mt-3">Permission</h3>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <?= $this->render('_permission-list', [
            'items' => $allPermissions,
            'type' => 'all',
        ]) ?>
    </div>
    <div class="col-lg-6">
        <?= $this->render('_permission-list', [
            'items' => $entity->getChildren(),
            'type' => 'role',
        ]) ?>
    </div>

</div>