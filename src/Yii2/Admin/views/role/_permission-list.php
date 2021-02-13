<?php


/**
 * @var View $this
 * @var Request $request
 * @var Role $entity
 * @var string $type
 * @var ItemEntity[] | Collection $items
 */

use Illuminate\Support\Collection;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Request;
use yii\web\View;
use ZnBundle\Rbac\Domain\Entities\Item;
use ZnBundle\Rbac\Domain\Entities\ItemEntity;
use ZnBundle\Rbac\Domain\Entities\Role;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;

?>

<?php if (!$items->isEmpty()): ?>
    <div class="list-group mb-3">
        <?php foreach ($items as $permissionEntity):
            $title = $permissionEntity->getTitle();// . " <small class='text-muted'>{$permissionEntity->name}</small>";
            ?>
            <span class="list-group-item">
                <?php if ($permissionEntity->type == Item::TYPE_ROLE): ?>
                    <?= Html::a($title, ['/rbac/role/view', 'id' => $permissionEntity->getId()]) ?>
                <?php else: ?>
                    <?= Html::a($title, ['/rbac/permission/view', 'id' => $permissionEntity->getId()]) ?>
                <?php endif; ?>
                <div class="float-right">
                    <?php if ($type == 'all'): ?>
                        <a href="<?= Url::to(['/rbac/role/attach', 'id' => $permissionEntity->getId()]) ?>"
                           title="<?= I18Next::t('core', 'action.delete') ?>"
                           class="text-decoration-none text-success" data-method="post">
                            <i class="far fa-plus-square"></i>
                        </a>
                    <?php else: ?>
                        <a href="<?= Url::to(['/rbac/role/detach', 'id' => $permissionEntity->getId()]) ?>"
                           title="<?= I18Next::t('core', 'action.delete') ?>"
                           class="text-decoration-none text-danger" data-method="post">
                            <i class="far fa-minus-square"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </span>
        <?php endforeach; ?>
    </div>

<?php else: ?>
    <div class="alert alert-secondary" role="alert">
        <?= I18Next::t('web', 'message.empty_list') ?>
    </div>
<?php endif; ?>