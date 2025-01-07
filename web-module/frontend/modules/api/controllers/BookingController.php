<?php

namespace frontend\modules\api\controllers;

use common\models\Booking;
use common\models\Budget;
use frontend\modules\api\helpers\AuthBehavior;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class BookingController extends ActiveController
{
    public $modelClass = 'common\models\Booking';
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
            'view' => ['GET'],

        ]);
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if(\Yii::$app->user->identity->hasRole('admin') || \Yii::$app->user->identity->hasRole('manager') || \Yii::$app->user->identity->hasRole('technician'))  {
            throw new \yii\web\ForbiddenHttpException('You can only view bookings');
        }
    }

    public function actionIndex($page = 1, $perPage = 10)
    {
        $activeDataProvider = new ActiveDataProvider([
            'query' => Booking::find(),
            'pagination' => [
                'defaultPageSize' => $perPage,
                'pageSizeLimit' => [1, 100],
                'pageParam' => 'page',
            ],
        ]);

        return ['bookings' => $activeDataProvider, 'page' => $page, 'total'=> $activeDataProvider->getTotalCount(), "status" => "success"];
    }

    public function actionView($id)
    {
        $booking = Booking::findOne($id);
        if($booking){
            return ['budget' => $booking, "status" => "success"];
        } else {
            return ['message' => "Budget not found", "status" => "error"];
        }
    }

    public function actionCreate()
    {
        $bookingModel = new Booking();
        $bookingModel->load(\Yii::$app->request->post(), '');
        $bookingModel->client_id = \Yii::$app->user->id;

        if ($bookingModel->validate() && $bookingModel->save()) {
            return ['booking' => $bookingModel, 'status'=> "success"];
        } else {
            return ['message' => 'Failed to create booking', 'status' => "error"];
        }
    }
}
