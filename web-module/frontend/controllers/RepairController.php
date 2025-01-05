<?php

namespace frontend\controllers;

use common\models\Invoice;
use common\models\Repair;
use frontend\modules\api\helpers\AuthBehavior;
use http\Url;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\Controller;
use Yii;

class RepairController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => AuthBehavior::class,
                'except' => ['index'],
            ],
        ]);
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['update']);
        unset($actions['create']);
        unset($actions['delete']);
        return $actions;
    }


    public function actionIndex()
    {
        if (Yii::$app->user->hasRole('client') === false) {
            $repairs = Repair::find()->all();
        } else {
            $repairs = Repair::find()->where(['client_id' => Yii::$app->user->id])->all();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $repairs,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->client_id !== Yii::$app->user->id && Yii::$app->user->hasRole('client') === true) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('view', [
           'model' => $this->findModel($id),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    public function actionChangeProgress($id, $progress)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->hasRole('repairTechnician') === true) {
            $model->progress = $progress;
            $model->save();
            return ['message' => 'Progress updated successfully', 'status' => 'success'];
        }
        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDownloadInvoice($id)
    {
        if (Yii::$app->user->hasRole('client') && Yii::$app->user->id !== Invoice::findOne($id)->repair->client_id) {
            $invoice = Invoice::findOne($id);
        } else {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        $path = Yii::$app->params["backend_url"] . '/' . $invoice->pdf_file;
        return Yii::$app->response->redirect($path);
    }

    protected function findModel($id)
    {
        if (($model = Repair::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }


}
