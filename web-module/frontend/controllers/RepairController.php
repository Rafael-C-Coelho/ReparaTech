<?php

namespace frontend\controllers;

use common\models\Invoice;
use common\models\Repair;
use frontend\modules\api\helpers\AuthBehavior;
use http\Url;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class RepairController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => AccessControl::class,
                'except' => ['index', 'view', 'download-invoice'],
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
        if (Yii::$app->user->identity->hasRole('client') === false) {
            $repairs = Repair::find();
        } else {
            $repairs = Repair::find()->where(['client_id' => Yii::$app->user->id]);
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

    public function actionAcceptBudget($id, $budget_id)
    {
        $model = $this->findModel($id);
        $budget = \common\models\Budget::findOne($budget_id);

        // Verify ownership and permissions
        if ($model->client_id !== Yii::$app->user->id || !Yii::$app->user->identity->hasRole('client')) {
            throw new \yii\web\ForbiddenHttpException('You are not allowed to perform this action.');
        }

        // Verify budget belongs to this repair
        if ($budget->repair_id !== $model->id || $budget->status !== \common\models\Budget::STATUS_PENDING) {
            throw new \yii\web\NotFoundHttpException('Invalid budget.');
        }

        $budget->status = \common\models\Budget::STATUS_APPROVED;
        if ($budget->save()) {
            Yii::$app->session->setFlash('success', 'Budget has been accepted.');
        } else {
            Yii::$app->session->setFlash('error', 'There was an error accepting the budget.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionRejectBudget($id, $budget_id)
    {
        $model = $this->findModel($id);
        $budget = \common\models\Budget::findOne($budget_id);

        // Verify ownership and permissions
        if ($model->client_id !== Yii::$app->user->id || !Yii::$app->user->identity->hasRole('client')) {
            throw new \yii\web\ForbiddenHttpException('You are not allowed to perform this action.');
        }

        // Verify budget belongs to this repair
        if ($budget->repair_id !== $model->id || $budget->status !== \common\models\Budget::STATUS_PENDING) {
            throw new \yii\web\NotFoundHttpException('Invalid budget.');
        }

        $budget->status = \common\models\Budget::STATUS_REJECTED;
        if ($budget->save()) {
            Yii::$app->session->setFlash('success', 'Budget has been rejected.');
        } else {
            Yii::$app->session->setFlash('error', 'There was an error rejecting the budget.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->client_id !== Yii::$app->user->id && Yii::$app->user->identity->hasRole('client') === true) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    public function actionDownloadInvoice($id)
    {
        if (Yii::$app->user->identity->hasRole('client') && Yii::$app->user->id === Invoice::findOne($id)->repair->client_id) {
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
