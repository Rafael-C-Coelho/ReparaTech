<?php

namespace frontend\modules\api\controllers;

use common\models\FavoriteProduct;
use FontLib\Table\Type\post;
use frontend\modules\api\helpers\AuthBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class FavouriteProductController extends ActiveController
{
    public $modelClass = 'common\models\FavouriteProduct';
    public $user = null;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            /*$behaviors ['favorite-product'] = [
                'class' => AuthBehavior::class,
            ],
            */
            'authenticator' => [
                'class' => AuthBehavior::class,
                'except' => [],
            ]
        ]);
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function verbs()
    {
        return array_merge(parent::verbs(), [
            'index' => ['GET'],
            'view' => ['GET'],
            'create' => ['POST'],
            'delete' => ['DELETE'],
        ]);
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if(\Yii::$app->user->identity->hasRole('admin') || \Yii::$app->user->identity->hasRole('manager') || \Yii::$app->user->identity->hasRole('manager') || \Yii::$app->user->identity->hasRole('technician'))  {
            throw new \yii\web\ForbiddenHttpException('You can only view favourite products');
        }
    }

    public function actionIndex($page = 1, $perPage = 10)
    {
        $activeDataProvider = new ActiveDataProvider([
            'query' => FavoriteProduct::find(),
            'pagination' => [
                'defaultPageSize' => $perPage,
                'pageSizeLimit' => [1, 100],
                'pageParam' => 'page',
            ],
        ]);
        return ['favouriteProducts' => $activeDataProvider, 'page'=> $page, 'total' => $activeDataProvider->getTotalCount(), 'status'=> "success"];
    }

    public function actionView($id)
    {
        $favouriteProduct = FavoriteProduct::findOne($id);
        if($favouriteProduct){
            return ['favouriteProduct' => $favouriteProduct, 'status'=> "success"];
        } else {
            return ['message' => 'not found', 'status'=> "error"];
        }
    }

    public function actionCreate()
    {
        $favouriteProduct = new FavoriteProduct();
        $favouriteProduct -> load(Yii::$app->request->post(), '');

        if ($favouriteProduct->validate() && $favouriteProduct->save()) {
            return ['favouriteProduct' => $favouriteProduct, 'status'=> "success"];
        } else
            return ['message' => 'Failed to create favourite product', 'status'=> "error"];
    }

    public function actionDelete($id){
        $favouriteProduct = FavoriteProduct::findOne($id);
        if($favouriteProduct){
            if ($favouriteProduct->delete()) {
                return ['message' => 'Product deleted successfully', 'status' => 'success'];
            } else{
                return ['message' => 'Failed to delete product', 'status' => 'error'];
            }
        } else {
            return ['message' => 'Favourite product not found', 'status'=> "error"];
        }
    }

}
