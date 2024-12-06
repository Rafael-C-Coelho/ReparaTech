<?php

namespace frontend\modules\api\helpers;

use common\models\User;
use Yii;
use yii\base\ActionFilter;

class AuthBehavior extends ActionFilter
{
    public function beforeAction($action)
    {
        $headers = Yii::$app->request->headers;
        $authHeader = $headers->get('Authorization');

        if ($authHeader && preg_match('/^Bearer\s+(.*)$/', $authHeader, $matches)) {
            $claims = JwtHelper::validateToken($matches[1]);
            if ($claims) {
                Yii::$app->user->identity = User::findOne($claims->get('uid'));
                return true;
            }
        }

        Yii::$app->response->statusCode = 401;
        return false;
    }
}
