<?php

namespace frontend\controllers;

use common\models\Invoice;
use common\models\Sale;
use Yii;
use yii\data\ActiveDataProvider;


class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Sale::find()->where(['client_id' => \Yii::$app->user->id]),
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

        return $this->render('view', [
        'model' => $model,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

    }


    public function actionDownloadInvoice($id){
        $invoice = Invoice::findOne($id);
        $path = \Yii::$app->params["backend_url"] . '/' .$invoice->pdf_file;
        return Yii::$app->response->redirect($path);
    }

    protected function findModel($id)
    {
        if (($model = Sale::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
}

