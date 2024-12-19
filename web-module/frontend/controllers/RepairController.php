<?php

namespace frontend\controllers;

use common\models\Invoice;
use common\models\Repair;
use http\Url;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\Controller;
use Yii;

class RepairController extends Controller
{
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Repair::find()->where(['client_id' => Yii::$app->user->id]),
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
        return $this->render('view', [
           'model' => $this->findModel($id),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    public function actionDownloadInvoice($id)
    {
        $invoice = Invoice::findOne($id);
        $path = Yii::$app->params["backend_url"] . '/' .$invoice->pdf_file;
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
