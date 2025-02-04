<?php

namespace frontend\controllers;

use common\models\Invoice;
use common\models\Product;
use common\models\Sale;
use common\models\SaleProduct;
use Dompdf\Dompdf;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\FileHelper;
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
        $recent_added_products = Product::find()->orderBy('id DESC')->limit(4)->all();
        $most_bought_products_on_saleproducts = SaleProduct::find()
            ->select('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderBy('total_quantity DESC')
            ->limit(4)
            ->all();

        $most_bought_products = [];
        foreach ($most_bought_products_on_saleproducts as $most_bought_product) {
            $product = Product::findOne($most_bought_product->product_id);
            if ($product) {
                $most_bought_products[] = $product;
            }
        }
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
    
    public function actionCheckout() {
        $cart = Yii::$app->session->get('cart', []);
        if (empty($cart)) {
            Yii::$app->session->setFlash('error', 'Your cart is empty.');
            return $this->redirect(['product/cart']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $sale = new Sale();
            $sale->client_id = Yii::$app->user->id;
            $sale->address = Yii::$app->request->post('address');
            $sale->zip_code = Yii::$app->request->post('zipCode');
            $total = 0;
            $items = [];
            if (!$sale->save()) {
                throw new \Exception('Failed to save sale.');
            }

            foreach ($cart as $productId => $details) {
                $product = Product::findOne($details['product_id']);
                if (!$product) {
                    throw new \Exception('Product not found.');
                }

                $saleProduct = new SaleProduct();
                $saleProduct->sale_id = $sale->id;
                $saleProduct->product_id = $product->id;
                $saleProduct->quantity = $details['quantity'];
                $saleProduct->total_price = $product->price * $details['quantity'];
                $product->stock = $product->stock - $details['quantity'];
                $items[] = [
                    'name' => $product->name,
                    'quantity' => $details['quantity'],
                    'price' => $product->price,
                ];

                if (!$saleProduct->save()) {
                    throw new \Exception('Failed to save sale product.');
                }
                $product->save();
                $total += $product->price * $details["quantity"];
            }

            $items[] = [
                'name' => "Shipping",
                'quantity' => 1,
                'price' => Yii::$app->params['defaultShipping'],
            ];
            $total += Yii::$app->params['defaultShipping'];

            if (!$sale->save()) {
                throw new \Exception('Failed to update sale total.');
            }

            $path = \Yii::getAlias('@app/web/uploads/invoices');
            FileHelper::createDirectory($path);

            // Save file path to the model
            $invoice = new Invoice();
            $invoice->client_id = Yii::$app->user->id;
            $invoice->total = $total;
            $invoice->items = json_encode($items);
            $invoice->save();

            $fileName = 'invoice_' . $invoice->id . Yii::$app->user->identity->id . Yii::$app->user->identity->username . $invoice->id . '.pdf';
            $filePath = $path . DIRECTORY_SEPARATOR . $fileName;
            $sale->invoice_id = $invoice->id;

            $content = \Yii::$app->controller->renderPartial('invoice-sale', [
                'model' => $sale,
                'items' => $items,
                'invoice' => $invoice
            ]);
            $dompdf = new Dompdf();
            $dompdf->loadHtml($content);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Save PDF to file
            file_put_contents($filePath, $dompdf->output());

            $invoice->pdf_file = '/uploads/invoices/' . $fileName;
            $invoice->save();
            $sale->save();
            $transaction->commit();
            Yii::$app->session->remove('cart');
            Yii::$app->session->setFlash('success', 'Purchase completed successfully.');
            return $this->redirect(['site/painelClient']);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Failed to complete purchase: ' . $e->getMessage());
            return $this->redirect(['product/cart']);
        }
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
            Yii::$app->session->setFlash('error', 'Signup failed');
            foreach ($model->errors as $error) {
                Yii::$app->session->setFlash('error', $error);
            }
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
        if ($model->load(Yii::$app->request->post())) {
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
