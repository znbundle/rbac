<?php

/**
 * @var View $this
 * @var Request $request
 * @var Model $model
 */

use yii\base\Model;
use yii\web\Request;
use yii\web\View;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;

$this->title = I18Next::t('core', 'action.create');

echo $this->render('_form', [
    'request' => $request,
    'model' => $model,
]);
