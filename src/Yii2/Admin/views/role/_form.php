<?php

/**
 * @var View $this
 * @var Request $request
 * @var CategoryForm $model
 */

use Incloud\Packages\Shop\Yii2\Admin\Forms\CategoryForm;
use yii\helpers\Html;
use yii\web\Request;
use yii\web\View;
use yii\widgets\ActiveForm;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnYii\Web\Widgets\CancelButton\CancelButtonWidget;

?>

<div class="row">

    <div class="col-lg-12">

        <?php $form = ActiveForm::begin(['id' => 'roleform']) ?>

        <div class="form-row">
            <div class="form-group col-md-12">
                <?= Html::activeLabel($model, 'name'); ?>
                <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']); ?>
                <?= Html::error($model, 'name', ['class' => 'text-danger']); ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <?= Html::activeLabel($model, 'description'); ?>
                <?= Html::activeTextInput($model, 'description', ['class' => 'form-control']); ?>
                <?= Html::error($model, 'description', ['class' => 'text-danger']); ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <?= Html::activeLabel($model, 'ruleName'); ?>
                <?= Html::activeTextInput($model, 'ruleName', ['class' => 'form-control']); ?>
                <?= Html::error($model, 'ruleName', ['class' => 'text-danger']); ?>
            </div>
        </div>

        <?= Html::submitButton(I18Next::t('core', 'action.save'), ['class' => 'btn btn-success']) ?>

        <?= CancelButtonWidget::widget() ?>

        <?php ActiveForm::end() ?>

    </div>

</div>
