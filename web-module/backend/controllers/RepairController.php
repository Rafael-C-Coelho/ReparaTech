<?php

namespace backend\controllers;

use common\models\Repair;
use common\models\Invoice;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

/**
 * RepairController implements the CRUD actions for Repair model.
 */
class RepairController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['index', 'view', 'create', 'update'],
                    'rules' => [
                        [
                            'allow' => false,
                            'roles' => ['?', 'client'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['listRepairs'],
                            'actions' => ['index', 'view'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['createRepairs'],
                            'actions' => ['create'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['updateRepairs'],
                            'actions' => ['update'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index', 'view', 'create', 'update'],
                            'matchCallback' => function ($rule, $action) {
                                return $action->controller->findModel(\Yii::$app->request->get('id'))->repairman_id === \Yii::$app->user->id;
                            },
                        ],
                    ],
                ]
            ]
        );
    }

    /**
     * Lists all Repair models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (isset(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id)['repairTechnician'])) {
            $dataProvider = new ActiveDataProvider([
                'query' => Repair::find()->where(['repairman_id' => \Yii::$app->user->id]),
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Repair::find(),
            ]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Repair model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (isset(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id)['repairTechnician'])) {
            $model = $this->findModel($id);
            if ($model->repairman_id !== \Yii::$app->user->id) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
            "dataProviderBudgets" => new ActiveDataProvider([
                'query' => $this->findModel($id)->getBudgets(),
            ]),
            "dataProviderComments" => new ActiveDataProvider([
                'query' => $this->findModel($id)->getComments(),
            ])
        ]);
    }

    /**
     * Creates a new Repair model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Repair();

        if ($this->request->isPost) {
            $model->load($this->request->post());
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'clients' => User::getClients(),
            'repairTechnicians' => User::getRepairTechnicians()
        ]);
    }

    /**
     * Updates an existing Repair model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (isset(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id)['repairTechnician'])) {
            if ($model->repairman_id !== \Yii::$app->user->id) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'clients' => User::getClients(),
            'repairTechnicians' => User::getRepairTechnicians(),
            "dataProviderBudgets" => new ActiveDataProvider([
                'query' => $this->findModel($id)->getBudgets(),
            ]),
            "dataProviderComments" => new ActiveDataProvider([
                'query' => $this->findModel($id)->getComments(),
            ])
        ]);
    }

    /**
     * Finds the Repair model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Repair the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Repair::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
