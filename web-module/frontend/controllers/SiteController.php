<?php

namespace frontend\controllers;

use common\models\Product;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'account'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['account'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'awnjmkoinçFE091U328HJRFN2MP0JFINp98NFWP982NE' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $recent_added_products = Product::find()->orderBy('created_at DESC')->limit(4)->all();
        $most_bought_products = Product::find()->limit(4)->all();
        return $this->render('index', [
            'recent_added_products' => $recent_added_products,
            'most_bought_products' => $most_bought_products,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionInformation(){

        $model = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->session->setFlash('success', 'Information updated successfully.');
            return $this->redirect(['site/painelClient']);
        }

        return $this->render('personalInformation', [
            'model' => $model,
        ]);
    }

    public function actionCart() {
        return $this->render('cart');
    }

    public function actionCheckout() {
        return $this->render('checkout');
    }

    public function actionShop() {
        return $this->render('shop');
    }

    public function actionDetail() {
        return $this->render('detail');
    }

    public function actionPainelClient(){
        return $this->render('painelClient');
    }

    public function actionContact(){
        return $this->render('contact', [
            'model' => new ContactForm(),
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        if ($model->hasErrors()) {
            Yii::$app->session->setFlash('error', 'Signup failed: ' . json_encode($model->errors));
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionAccount()
    {
        return $this->render('about');
    }


    public function actionRepair(){
        return $this->render('repair',
            [
            'dataProvider' => new \yii\data\ActiveDataProvider([
                'query' => \common\models\Repair::find()->where(['client_id' => Yii::$app->user->id]),
            ])
        ]);
    }

    public function actionOrder() {
        return $this->render('order',
            [
                'dataProvider' => new \yii\data\ActiveDataProvider([
                'query' => \common\models\SaleProduct::find()->where(['sale_id' => Yii::$app->user->id]),
                ])
            ]
        );
    }

    public function actionHardwareCleaningMaintenance(){
        return $this->render('repairCategory/hardwareCleaningMaintenance');
    }

    public function actionDataRecovery(){
        return $this->render('repairCategory/dataRecovery');
    }

    public function actionSoftwareIssue(){
        return $this->render('repairCategory/softwareIssue');
    }

    public function actionNetworkIssue(){
        return $this->render('repairCategory/networkIssue');
    }

    public function actionDamageButton(){
        return $this->render('repairCategory/damageButton');
    }

    public function actionBatteryIssue(){
        return $this->render('repairCategory/batteryIssue');
    }

    public function  actionStorageIssue(){
        return $this->render('repairCategory/storageIssue');
    }

    public function actionCameraIssue(){
        return $this->render('repairCategory/cameraIssue');
    }

    public function actionLiquidDamage(){
        return $this->render('repairCategory/liquidDamage');
    }

    public function actionConnectivityIssue(){
        return $this->render('repairCategory/connectivityIssue');
    }

    public function actionBrokenScreen(){
        return $this->render('repairCategory/brokenScreen');
    }

    public function actionAudioIssue(){
        return $this->render('repairCategory/audioIssue');
    }

    public function actionAllRepairCategories(){
        return $this->render('repairCategory/allRepairCategories');
    }



}
