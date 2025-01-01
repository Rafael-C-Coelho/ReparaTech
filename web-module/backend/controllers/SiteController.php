<?php

namespace backend\controllers;

use common\models\Invoice;
use common\models\LoginForm;
use common\models\Product;
use common\models\ProductCategory;
use common\models\Repair;
use common\models\Sale;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

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
                'rules' => [
                    [
                        'roles' => ['?'],
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['storeOwner', 'manager', 'repairTechnician'],
                    ],

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
                'layout' => 'blank',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->hasRole('repairTechnician')) {
            $totalRevenue = 0;
            foreach (Repair::find()->where(['repairman_id' => Yii::$app->user->id])->all() as $repair) {
                $totalRevenue += $repair->invoice->total;
            }
            return $this->render('index-repairman', [
                'totalRepairs' => Repair::find()->where(['repairman_id' => Yii::$app->user->id])->count(),
                'totalRevenue' => $totalRevenue,
            ]);
        }
        return $this->render('index', [
            'revenue' => Invoice::find()->sum('total'),
            'totalSales' => Sale::find()->count(),
            'totalRepairs' => Repair::find()->count(),
            'totalClients' => Invoice::find()->select('client_id')->distinct()->count(),
            'totalProducts' => Product::find()->count(),
            'totalRevenueWeek' => Invoice::find()->where(['>=', 'date', date('Y-m-d', strtotime('-1 week'))])->sum('total'),
            'totalRevenueMonth' => Invoice::find()->where(['>=', 'date', date('Y-m-d', strtotime('-1 month'))])->sum('total'),
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
