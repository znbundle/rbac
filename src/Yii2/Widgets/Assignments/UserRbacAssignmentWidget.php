<?php

namespace ZnBundle\Rbac\Yii2\Widgets\Assignments;

use Yii;
use ZnBundle\Rbac\Domain\Entities\Assignment;
use ZnLib\Web\Widgets\Base\BaseWidget2;

class UserRbacAssignmentWidget extends BaseWidget2
{

    public $userId;

    public function run(): string
    {
        /** @var Assignment[] $assignments */
        $assignments = Yii::$app->authManager->getAssignments($this->userId);
        foreach ($assignments as &$assignment) {
            $assignment->role = Yii::$app->authManager->getRole($assignment->roleName);
        }
        $permissions = Yii::$app->authManager->getPermissionsByUser($this->userId);
        return $this->render('index', [
            'permissions' => $permissions,
            'assignments' => $assignments,
        ]);
    }
}
