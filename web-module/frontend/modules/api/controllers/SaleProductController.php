<?php

namespace frontend\modules\api\controllers;

use common\models\SaleProduct;
use frontend\modules\api\helpers\AuthBehavior;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class SaleProductController extends ActiveController
{
    public $modelClass = 'common\models\SaleProduct';
    public $user = null;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => AuthBehavior::class,
                'except' => ['index', 'view', 'latest-inserted'],
            ]
        ]);
    }

    public function actions(){
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        return $actions;
    }

    protected function verbs(){
        return array_merge(parent::verbs(),
            [
                'index' => ['GET'],
                'view' => ['GET'],
                'create' => ['POST'],
            ]
        );
    }

    public function checkAccess($action, $model = null, $params = []){
        if($action === 'create'){
            if(\Yii::$app->user->identity->hasRole('admin' || 'technician' || 'manager')){
                throw new \yii\web\ForbiddenHttpException('You can only view sales.');
            }
        }
    }

    public function actionIndex(){
        $activeData = new ActiveDataProvider([
            'query' => SaleProduct::find(),
        ]);
        return ['saleProducts' => $activeData->getModels(), 'total' => $activeData->getTotalCount(), "status" => "success"];
    }

    public function actionView($id){
        $saleProduct = SaleProduct::findOne($id);
        if($saleProduct){
            return ['saleProduct' => $saleProduct, "status" => "success"];
        }
        return ['message' => 'SaleProduct not found', "status" => "error"];
    }

    public function actionCreate(){
        $saleProduct = new SaleProduct();
        $saleProduct->load(\Yii::$app->request->post(), '');
        if($saleProduct->save()){
            return ['saleProduct' => $saleProduct, "status" => "success"];
        }
        return ['message' => 'SaleProduct not created', "status" => "error"];
    }
}
