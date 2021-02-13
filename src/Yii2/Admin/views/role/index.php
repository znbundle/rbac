<?php

/**
 * @var View $this
 * @var Request $request
 * @var DataProvider $dataProvider
 * @var ValidateEntityByMetadataInterface $filterModel
 */

use yii\helpers\Url;
use yii\web\Request;
use yii\web\View;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Libs\DataProvider;
use ZnLib\Web\Widgets\Collection\CollectionWidget;
use ZnLib\Web\Widgets\Format\Formatters\ActionFormatter;
use ZnLib\Web\Widgets\Format\Formatters\LinkFormatter;

$this->title = I18Next::t('rbac', 'role.list');

//$statusWidget = new FilterWidget(StatusEnum::class, $filterModel);

$attributes = [
    [
        'label' => 'ID',
        'attributeName' => 'id',
    ],
    [
        'label' => I18Next::t('rbac', 'item.attribute.title'),
        'attributeName' => 'description',
        'sort' => true,
        'formatter' => [
            'class' => LinkFormatter::class,
            'uri' => '/rbac/role/view',
        ],
    ],
    [
        'label' => I18Next::t('rbac', 'item.attribute.name'),
        'attributeName' => 'name',
        'sort' => true,
    ],
    [
        'formatter' => [
            'class' => ActionFormatter::class,
            'actions' => [
                'update',
                'delete',
            ],
            'baseUrl' => '/rbac/role',
        ],
    ],
];

?>

<div class="row">

    <div class="col-lg-12">

        <?= CollectionWidget::widget([
            'dataProvider' => $dataProvider,
            'attributes' => $attributes,
        ]) ?>

        <div class="float-left">
            <a class="btn btn-primary" href="<?= Url::to(['/rbac/role/create']) ?>" role="button">
                <i class="fa fa-plus"></i>
                <?= I18Next::t('core', 'action.create') ?>
            </a>
        </div>

    </div>

</div>
