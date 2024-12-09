<?php

namespace frontend\modules\api\controllers;

use common\models\User;
use frontend\modules\api\helpers\AuthBehavior;
use frontend\modules\api\helpers\JwtHelper;
use yii\web\Controller;

/**
 * Default controller for the `api` module
 */
class AuthController extends Controller
{
    public $user = null;

    public function beforeAction($action): bool
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            $behaviors['auth'] = [
                'class' => AuthBehavior::class,
                'except' => ['login', 'register', 'request-password-reset'],
            ],
        ]);
    }

    public function actionLogin()
    {
        $request = \Yii::$app->request;
        $email = $request->post('email');
        $password = $request->post('password');
        $user = User::findOne(['email' => $email]);

        if ($user && \Yii::$app->getSecurity()->validatePassword($password, $user->password_hash)) {
            $accessToken = JwtHelper::generateToken($user->id, $user->getRoles());
            $refreshToken = \Yii::$app->security->generateRandomString();

            $user->refresh_token = $refreshToken;
            $user->save(false);

            return $this->asJson([
                'status' => 'success',
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
            ]);
        }

        return $this->asJson([
            'status' => 'error',
            'message' => 'Invalid email or password.',
        ]);
    }


    public function actionRegister()
    {
        $request = \Yii::$app->request;
        $email = $request->post('email');
        $password = $request->post('password');
        $username = $request->post('username');
        $name = $request->post('name');

        if (User::findOne(['email' => $email])) {
            return $this->asJson([
                'status' => 'error',
                'message' => 'Email already exists.',
            ]);
        }

        $user = new User();
        $user->email = $email;
        $user->name = $name;
        $user->password = $password;
        $user->username = $username;
        $user->password_hash = \Yii::$app->security->generatePasswordHash($password);
        $user->auth_key = \Yii::$app->security->generateRandomString();
        $user->created_at = time();
        $user->updated_at = time();

        if ($user->save()) {
            $user->generateEmailVerificationToken();
            return $this->asJson([
                'status' => 'success',
                'message' => 'Registration successful.',
            ]);
        }

        return $this->asJson([
            'status' => 'error',
            'message' => 'Failed to register.',
            'errors' => $user->errors,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $email = \Yii::$app->request->post('email');
        $user = User::findOne(['email' => $email]);

        if (!$user) {
            return $this->asJson([
                'status' => 'success',
                'message' => 'Password reset token sent to your email.',
            ]);
        }

        $user->password_reset_token = \Yii::$app->security->generateRandomString() . '_' . time();
        if ($user->save(false)) {
            // Send email (use Yii2 Mailer)
            \Yii::$app->mailer->compose(
                    ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                    ['user' => $user]
                )
                ->setTo($user->email)
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                ->setSubject('Password Reset')
                ->send();

            return $this->asJson([
                'status' => 'success',
                'message' => 'Password reset token sent to your email.',
            ]);
        }

        return $this->asJson([
            'status' => 'error',
            'message' => 'Failed to generate password reset token.',
        ]);
    }

    public function actionProfile()
    {
        $user = \Yii::$app->user->identity;

        return $this->asJson([
            'status' => 'success',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoles(),
            ],
        ]);
    }

    public function actionUpdateProfile()
    {
        $user = \Yii::$app->user->identity;

        $name = \Yii::$app->request->post('name');
        $email = \Yii::$app->request->post('email');

        if ($name) {
            $user->name = $name;
        }

        if ($email && $email !== $user->email) {
            if (User::findOne(['email' => $email])) {
                return $this->asJson([
                    'status' => 'error',
                    'message' => 'Email already in use.',
                ]);
            }
            $user->email = $email;
        }

        if ($user->save(false)) {
            return $this->asJson([
                'status' => 'success',
                'message' => 'Profile updated successfully.',
            ]);
        }

        return $this->asJson([
            'status' => 'error',
            'message' => 'Failed to update profile.',
            'errors' => $user->errors,
        ]);
    }

    public function actionRefreshToken()
    {
        $refreshToken = \Yii::$app->request->post('refresh_token');
        if (!$refreshToken) {
            return $this->asJson([
                'status' => 'error',
                'message' => 'Refresh token is required.',
            ]);
        }
        $user = User::findOne(['refresh_token' => $refreshToken]);

        if (!$user) {
            return $this->asJson([
                'status' => 'error',
                'message' => 'Invalid refresh token.',
            ]);
        }

        $newAccessToken = JwtHelper::generateToken($user->id, $user->getRoles());
        $newRefreshToken = \Yii::$app->security->generateRandomString();

        $user->refresh_token = $newRefreshToken;
        $user->save(false);

        return $this->asJson([
            'status' => 'success',
            'access_token' => $newAccessToken,
            'refresh_token' => $newRefreshToken,
        ]);
    }

    public function actionLogout()
    {
        $user = \Yii::$app->user->identity;

        if (!$user) {
            return $this->asJson([
                'status' => 'error',
                'message' => 'Invalid refresh token.',
            ]);
        }

        $user->refresh_token = null;
        $user->save(false);

        return $this->asJson([
            'status' => 'success',
            'message' => 'Logged out successfully.',
        ]);
    }
}
