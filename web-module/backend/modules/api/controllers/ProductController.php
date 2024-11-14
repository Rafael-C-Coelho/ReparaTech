<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Controller;

/**
 * Default controller for the `api` module
 */
class ProductController extends ActiveController
{
    public $modelClass = 'common\models\Product';
    public $user = null;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => \yii\filters\auth\HttpBasicAuth::class,
                'auth' => [$this, 'auth'],
                'except' => ['index', 'view']
            ],
        ]);
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'create' || $action === 'update' || $action === 'delete') {
            if (isset(\Yii::$app->authManager->getRolesByUser($this->user->id)[""])) {
                throw new \yii\web\ForbiddenHttpException('You can only ' . $action . ' products that you\'ve created.');
            }
        }
    }
}
