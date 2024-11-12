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

    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    'class' => \yii\filters\AccessRule::class,
                    'only' => ['create', 'update', 'delete'],
                    "allow" => true,
                    "roles" => ["storeOwner", "manager"],
                ],
            ],
        ];
    }
}
