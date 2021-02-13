<?php

/**
 * @var View $this
 * @var Permission[] $permissions
 * @var Assignment[] $assignments
 */

use yii\helpers\Html;
use yii\web\View;
use ZnBundle\Rbac\Domain\Entities\Assignment;
use ZnBundle\Rbac\Domain\Entities\Permission;

$baseUrl = '/rbac/permission';

?>

<ul class="nav nav-pills">
    <li class="nav-item"><a class="nav-link active" href="#assignment" data-toggle="tab">Assignment</a></li>
    <li class="nav-item"><a class="nav-link" href="#permissionList" data-toggle="tab">Permission</a></li>
</ul>

<div class="tab-content mt-3">
    <div class="tab-pane active" id="assignment">
        <div class="list-group">
            <?php foreach ($assignments as $assignmentEntity): ?>
                <span class="list-group-item">
                    <?= Html::a($assignmentEntity->role->description, ['/rbac/role/view', 'name' => $assignmentEntity->roleName]) ?>
                </span>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="tab-pane" id="permissionList">
        <div class="list-group">
            <?php foreach ($permissions as $permission): ?>
                <span class="list-group-item">
                    <?= Html::a($permission->description, ['/rbac/permission/view', 'name' => $permission->name]) ?>
                </span>
            <?php endforeach; ?>
        </div>
    </div>
</div>
