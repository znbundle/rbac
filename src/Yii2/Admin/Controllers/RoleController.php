<?php

namespace ZnBundle\Rbac\Yii2\Admin\Controllers;

use DomainException;
use Illuminate\Container\Container;
use ZnBundle\Rbac\Yii2\Admin\Forms\ItemForm;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\helpers\Url;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnBundle\Rbac\Domain\Entities\Role;
use ZnBundle\Rbac\Domain\Entities\RoleEntity;
use ZnBundle\Rbac\Domain\Enums\Rbac\RbacRolePermissionEnum;
use ZnBundle\Rbac\Domain\Interfaces\ManagerServiceInterface;
use ZnBundle\Rbac\Domain\Interfaces\Services\ItemServiceInterface;
use ZnBundle\Rbac\Domain\Interfaces\Services\RoleServiceInterface;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Legacy\Yii\Helpers\Inflector;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Entities\Query\Where;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Libs\Query;
use ZnLib\Web\Widgets\BreadcrumbWidget;
use ZnYii\Base\Enums\ScenarionEnum;
use ZnYii\Base\Helpers\FormHelper;
use ZnYii\Web\Controllers\BaseController;

class RoleController extends BaseController
{

    protected $baseUri = '/rbac/role';
    protected $formClass = ItemForm::class;
    protected $entityClass = RoleEntity::class;
    //protected $filterModel = ContactFilter::class;
    private $roleService;
    private $itemService;
    private $managerService;
    private $toastrService;
    protected $defaultPerPage = 20;

    public function __construct(
        string $id,
        Module $module, array $config = [],
        BreadcrumbWidget $breadcrumbWidget,
        ManagerServiceInterface $managerService,
        RoleServiceInterface $roleService,
        ItemServiceInterface $itemService,
        ToastrServiceInterface $toastrService
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $roleService;
        $this->managerService = $managerService;
        $this->breadcrumbWidget = $breadcrumbWidget;
        $this->roleService = $roleService;
        $this->itemService = $itemService;
        $this->toastrService = $toastrService;
        $this->breadcrumbWidget->add(I18Next::t('rbac', 'role.list'), Url::to([$this->baseUri]));
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [RbacRolePermissionEnum::ALL],
                        'actions' => ['index'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [RbacRolePermissionEnum::ONE],
                        'actions' => ['view'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [RbacRolePermissionEnum::CREATE],
                        'actions' => ['create'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [RbacRolePermissionEnum::UPDATE],
                        'actions' => ['update'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [RbacRolePermissionEnum::DELETE],
                        'actions' => ['delete'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        $actions = parent::actions();
        return [
            'index' => $actions ['index'],
            //'view' =>$actions ['view'],
            'create' => $actions ['create'],
            'delete' => $actions ['delete'],
            'update' => $actions ['update'],
        ];
    }

    public function actionView(int $id = null, string $name = null)
    {
        $query = new Query();
        //$query->with(['children']);
        /** @var RoleEntity $entity */
        if ($id) {
            $entity = $this->roleService->oneById($id, $query);
        } elseif ($name) {
            $entity = $this->roleService->oneByName($name, $query);
        }

        $query = new Query();
        $query->perPage(99999);
        $allPermissions = $this->itemService->all($query);

        $permissions = $this->managerService->getPermissionsByRole($entity->name);
        $permissionNames = ArrayHelper::getColumn($permissions, 'name');
        $query = new Query();
        $query->perPage(99999);
        $query->whereNew(new Where('name', array_keys($permissionNames)));
        $permissions = $this->itemService->all($query);

        //dd($permissionNames);
        $entity->setChildren($permissions);

        $this->breadcrumbWidget->add(I18Next::t('core', 'action.view'), Url::to([$this->baseUri . '/view', 'name' => $entity->name]));
        return $this->render('view', [
            'entity' => $entity,
            //'permissions' => new Collection($permissions),
            'allPermissions' => $allPermissions,
        ]);
    }

    public function __________actionCreate()
    {
        $this->breadcrumbWidget->add(I18Next::t('core', 'action.create'), Url::to([$this->baseUri . '/create']));
        /** @var ItemForm $model */
//        $model = Container::getInstance()->get($this->formClass);
        $model = FormHelper::createFormByClass($this->formClass, ScenarionEnum::CREATE);
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post($model->formName());
            FormHelper::setAttributes($model, $postData);
            try {
                $entity = $this->managerService->createRole($model->name);
                $this->prepareModel($model);
                $this->fillEntity($entity, $model);

                $entity->name = 'r' . Inflector::camelize($entity->name);
                $this->managerService->add($entity);
                //$orderEntity = $this->service->create(FormHelper::extractAttributesForEntity($model, $this->entityClass));
                $this->toastrService->success(['web', 'message.create_success']);
                return $this->redirect([$this->baseUri . '/view', 'id' => $entity->getId()]);
            } catch (UnprocessibleEntityException $e) {
                $errors = FormHelper::setErrorsToModel($model, $e->getErrorCollection());
                $errorMessage = implode('<br/>', $errors);
                $this->toastrService->warning($errorMessage);
            }
        }
        return $this->render('create', [
            'request' => Yii::$app->request,
            'model' => $model,
        ]);
    }

    public function ______actionUpdate(string $name)
    {
        /** @var Role $entity */
        $entity = $this->roleService->oneById($name);
//        $entity = $this->managerService->getRole($name);
        $this->breadcrumbWidget->add(I18Next::t('core', 'action.update'), Url::to([$this->baseUri . '/update', 'name' => $entity->name]));

        /** @var ItemForm $model */
//        $model = Container::getInstance()->get($this->formClass);
        $model = FormHelper::createFormByClass($this->formClass, ScenarionEnum::UPDATE);

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post($model->formName());
            FormHelper::setAttributes($model, $postData);
            $this->prepareModel($model);
            $origName = $entity->name;
            $this->fillEntity($entity, $model);
            $entity->name = $origName;
            try {
                $this->managerService->update($entity->name, $entity);
                //$this->service->updateById($name, FormHelper::extractAttributesForEntity($model, $this->entityClass));
                $this->toastrService->success(['web', 'message.update_success']);
                return $this->redirect([$this->baseUri . '/view', 'name' => $entity->name]);
            } catch (UnprocessibleEntityException $e) {
                $errors = FormHelper::setErrorsToModel($model, $e->getErrorCollection());
                $errorMessage = implode('<br/>', $errors);
                $this->toastrService->warning($errorMessage);
            } catch (DomainException $e) {
                $this->toastrService->warning($e->getMessage());
            }
        } else {
            $data = EntityHelper::toArrayForTablize($entity);
            FormHelper::setAttributes($model, $data);
            $this->prepareModel($model);
        }
        return $this->render('update', [
            'request' => Yii::$app->request,
            'model' => $model,
        ]);
    }

    /*public function actionDelete(int $id)
    {
        try {
            $entity = $this->roleService->deleteById($id);
            Alert::create(['web', 'message.delete_success'], Alert::TYPE_SUCCESS);
        } catch (\DomainException $e) {
            Alert::create($e->getMessage(), Alert::TYPE_WARNING);
        }
        return $this->redirect([$this->baseUri]);
    }

    private function prepareModel(ItemForm $model)
    {
        $model->description = $model->description ?: null;
        $model->ruleName = $model->ruleName ?: null;
        $model->data = $model->data ?: null;
    }

    private function fillEntity(Item $entity, ItemForm $model)
    {
        $entity->name = $model->name;
        $entity->description = $model->description;
        $entity->ruleName = $model->ruleName;
        $entity->data = $model->data;
    }*/
}
