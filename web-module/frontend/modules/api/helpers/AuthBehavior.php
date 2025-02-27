<?php

namespace frontend\modules\api\helpers;

use common\models\User;
use Yii;
use yii\base\ActionFilter;
use yii\web\Response;

class AuthBehavior extends ActionFilter
{
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $headers = Yii::$app->request->headers;
        $authHeader = $headers->get('Authorization');

        if ($authHeader && preg_match('/^Bearer\s+(.*)$/', $authHeader, $matches)) {
            $claims = JwtHelper::validateToken($matches[1]);
            if ($claims && $claims !== 406) {
                try {
                    Yii::$app->user->identity = User::findOne($claims->get('uid'));
                } catch (\Exception $e) {
                    Yii::$app->response->statusCode = 401;
                    Yii::$app->response->data = ['status' => 'error', 'message' => 'Try logging in again.'];
                    return false;
                }
                return true;
            }
        }

        Yii::$app->response->statusCode = $claims ?? 401;
        Yii::$app->response->data = ['status' => 'error', 'message' => 'Unauthorized'];
        return false;
    }
}
