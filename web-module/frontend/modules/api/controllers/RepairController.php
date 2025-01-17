<?php

namespace frontend\modules\api\controllers;

use common\models\Repair;
use frontend\modules\api\helpers\AuthBehavior;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class RepairController extends ActiveController
{
    public $modelClass = 'common\models\Repair';
    public $user = null;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => AuthBehavior::class,
                'except' => [],
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
                'count' => ['GET'],
                'device' => ['GET'],
                'hours-spent-working' => ['GET'],
                'description' => ['GET'],
                'progress' => ['GET', 'PATCH'],
            ]
        );
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if($action === 'create' || $action === 'update' || $action === 'delete'){
            if(\Yii::$app->user->identity->hasRole('admin' || 'manager' || 'technician'))
            {
                throw new \yii\web\ForbiddenHttpException('You can only view repairs.');
            }
        }
    }

    public function actionIndex($page = 1, $perPage = 10)
    {
        if (\Yii::$app->user->identity->hasRole('repairTechnician') === false) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        $activeDataProvider = new ActiveDataProvider([
           'query' => Repair::find()->where(['repairman_id' => \Yii::$app->user->identity->id])->andWhere(['in', 'progress', [Repair::STATUS_IN_PROGRESS, Repair::STATUS_COMPLETED]]),
            'pagination' => [
                'defaultPageSize' => $perPage,
                'pageSizeLimit' => [1, 100],
                'pageParam' => 'page',
            ],
        ]);
        return ['repairs' => $activeDataProvider, 'page' => $page, 'total' => $activeDataProvider->getTotalCount(), "status" => "success"];
    }

    public function actionView($id)
    {
        $repair = Repair::findOne($id);
        if ($repair === null) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        if ($repair->repairman_id !== \Yii::$app->user->identity->id) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        if($repair){
            return ['repair' => $repair, "status" => "success"];
        } else {
            return ['message' => 'Repair not found', "status" => "error"];
        }
    }

    public function actionCount()
    {
        $repairModel = new $this->modelClass;
        $repairs = $repairModel::find()->where(["repairman_id" => $repairModel->repairman_id])->all();
        return ['count' => count($repairs)];
    }

    public function actionDevice($id)
    {
        $repairModel = new $this->modelClass;
        $repairs = $repairModel::find()->select(['device'])->where(['id' => $id])->one();
        return $repairs;
    }

    public function actionHoursSpentWorking($id)
    {
        $repairModel = new $this->modelClass;
        $hoursSpentWorking = $repairModel::find()->select(['hours_spent_working'])->where(['id' => $id])->one();

        return $hoursSpentWorking;
    }

    public function actionDescription($id){
        $repairModel = new $this->modelClass;
        $repairs = $repairModel::find()->select(['description'])->where(['id' => $id])->one();
        return $repairs;
    }

    public function actionProgress($id)
    {
        if (\Yii::$app->user->identity->hasRole('repairTechnician') === false) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        $model = new $this->modelClass;

        if ($this->request->isPatch) {
            $model = $model::findOne($id);
            $model->progress = $this->request->getBodyParam('progress');
            $wasSaved = $model->save();
            return ['message' => $wasSaved ? 'Progress updated successfully' : 'Progress not saved.', 'status' => 'success'];
        } elseif ($this->request->isGet) {
            return ['progress' => $model::findOne($id)->progress, 'status' => 'success'];
        } else {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }
}
