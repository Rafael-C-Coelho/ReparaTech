<?php

namespace frontend\modules\api\controllers;

use common\models\Product;
use frontend\modules\api\helpers\AuthBehavior;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class ProductController extends ActiveController
{
    public $modelClass = 'common\models\Product';
    public $user = null;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBearerAuth::class,
                'except' => ['index', 'view', 'latest-inserted'],
            ],
        ]);
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['update']);
        unset($actions['create']);
        unset($actions['delete']);
        return $actions;
    }

    protected function verbs()
    {
        return array_merge(parent::verbs(),
            [
                'latest' => ['GET'],
            ]
        );
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'create' || $action === 'update' || $action === 'delete') {
            if (\Yii::$app->user->identity->hasRole('admin')) {
                throw new \yii\web\ForbiddenHttpException('You can only view products.');
            }
        }
    }

    public function actionIndex($page = 1, $perPage = 10)
    {
        $activeData = new ActiveDataProvider([
            'query' => Product::find(),
            'pagination' => [
                'defaultPageSize' => $perPage,
                'pageSizeLimit' => [1, 100],
                'pageParam' => 'page',
            ],
        ]);
        return ['products' => $activeData, 'page' => $page, 'total' => $activeData->getTotalCount(), "status" => "success"];
    }

    public function actionView($id)
    {
        $product = Product::findOne($id);
        if ($product) {
            return ['product' => $product, "status" => "success"];
        }
        return ['message' => 'Product not found', "status" => "error"];
    }

    public function actionLatest()
    {
        $products = Product::find()->orderBy(['id' => SORT_DESC])->limit(4)->all();
        if ($products) {
            return ['products' => $products, "status" => "success"];
        }
        return ['message' => 'Product not found', "status" => "error"];
    }
}
