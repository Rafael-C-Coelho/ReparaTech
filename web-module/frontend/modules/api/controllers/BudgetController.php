<?php

namespace frontend\modules\api\controllers;

use common\models\Budget;
use frontend\modules\api\helpers\AuthBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class BudgetController extends ActiveController
{
    public $modelClass = 'common\models\Budget';
    public $user = null;

    public function behaviors(){
        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => AuthBehavior::class,
                'except' => [],
            ]
        ]);
    }

    public function actions(){
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['update']);
        unset($actions['create']);
        unset($actions['delete']);
        return $actions;
    }

    protected function verbs(){
        return array_merge(parent::verbs(), [
            'index' => ['GET'],
            'value' => ['GET'],
            'view' => ['GET'],
            'count' => ['GET'],
            'status' => ['GET'],
            'description' => ['GET'],
        ]);
    }

    public function checkAccess($action, $model = null, $params = [])
    {
       if (\Yii::$app->user->identity->hasRole('admin' || \Yii::$app->user->identity->hasRole('manager') || \Yii::$app->user->identity->hasRole('technician'))) {

           throw new \yii\web\ForbiddenHttpException('You can only view budgets.');
       }
    }

    public function actionIndex($page = 1, $perPage = 10)
    {
      $activeDataProvider = new ActiveDataProvider([
          'query' => Budget::find(),
          'pagination' => [
              'defaultPageSize' => $perPage,
              'pageSizeLimit' => [1, 100],
              'pageParam' => 'page',
          ],
      ]);

      return ['budgets' => $activeDataProvider, 'page' => $page, 'total'=> $activeDataProvider->getTotalCount(), "status" => "success"];
    }

    public function actionView($id)
    {
        $budget = Budget::findOne($id);
        if($budget){
            return ['budget' => $budget, "status" => "success"];
        } else {
            return ['message' => "Budget not found", "status" => "error"];
        }
    }


    public function actionCount()
    {
        $budgetModel = new $this->modelClass;
        $budgets = $budgetModel::find()->all();
        return ['count' => count($budgets)];
    }

    public function actionValue($id){
        $budgetModel =  new $this->modelClass;
        $budgets = $budgetModel::find()->select(['value'])->where(['id' => $id])->one();
        return $budgets;
    }

    public function actionStatus($id)
    {
        $budgetModel =  new $this->modelClass;
        $budgets = $budgetModel::find()->select(['status'])->where(['id' => $id])->one();
        return $budgets;
    }

    public function actionDescription($id)
    {
        $budgetModel = new $this->modelClass;
        $budgets = $budgetModel::find()->select(['description'])->where(['id' => $id])->one();
        return $budgets;
    }
}
