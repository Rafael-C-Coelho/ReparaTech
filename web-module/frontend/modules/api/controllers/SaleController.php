<?php

namespace frontend\modules\api\controllers;

use common\models\Sale;
use frontend\modules\api\helpers\AuthBehavior;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class SaleController extends ActiveController
{
    public $modelClass = 'common\models\Sale';
    public $user = null;

    public function behaviors(){
        return array(parent::behaviors(), [
            'authenticator' => [
                'class' => AuthBehavior::class,
                'except' => ['index', 'view'],
            ],
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
        return array_merge(parent::verbs(), [
            'latest' => ['GET'],
        ]);
    }

    public function checkAccess($action, $model = null, $params = []){
        if ($action === 'create' || $action === 'update' || $action === 'delete') {
            if (\Yii::$app->user->identity->hasRole('client')) {
                throw new \yii\web\ForbiddenHttpException('You can only view sales.');
            }
        }
    }

    public function actionIndex(){

        $activeData = new ActiveDataProvider([
            'query' => Sale::find()->with('saleProducts'),
        ]);
        return ['sales' => $activeData->getModels(), 'total' => $activeData->getTotalCount(), "status" => "success"];
    }

    public function actionView($id){
        $sale = Sale::findOne()->with('saleProducts')->where(['id' => $id])->one();
        if ($sale) {
            return ['sale' => $sale, 'sale_products' => $sale->saleProducts, "status" => "success"];
        }
        return ['message' => 'Sale not found', "status" => "error"];
    }

    public function actionCreate(){
        $sale = new Sale();
        $sale->load(\Yii::$app->request->post(), '');
        if ($sale->save()) {
            return ['sale' => $sale, "status" => "success"];
        }
        return ['message' => 'Sale not created', "status" => "error"];
    }

}
