<?php

namespace frontend\modules\api\controllers;

use common\models\Comment;
use frontend\modules\api\helpers\AuthBehavior;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class CommentController extends ActiveController
{
    public $modelClass = 'common\models\Comment';
    public $user = null;

    public function behaviors()
    {
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
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    protected function verbs(){
        return array_merge(parent::verbs(), []);
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if(\Yii::$app->user->identity->hasRole('admin' || 'manager')){

            throw new \yii\web\ForbiddenHttpException("You can only view comments.");
        }
    }

    public function actionIndex($page = 1, $perPage = 10){

        $activeDataProvider = new ActiveDataProvider([
            'query' => Comment::find(),
            'pagination' => [
                'defaultPageSize' => $perPage,
                'pageSizeLimit' => [1, 100],
                'pageParam' => 'page',
            ],
        ]);

        return (['comments' => $activeDataProvider, 'page' => $page, 'total'=> $activeDataProvider->getTotalCount(), "status" => "success"]);
    }

    public function actionView($id){
        $comment = Comment::findOne($id);
        if($comment){
            return ['comment' => $comment, 'status' => "success"];
        } else {
            return ['message' => "Comment not found", "status" => "error"];
        }
    }
    public function actionDescription($id){
        $commentModel = new $this->modelClass();
        $comments = $commentModel->find()->select(['description'])->where(['id'=>$id])->one();
        return $comments;
    }
}
