<?php

namespace backend\controllers;

use common\models\Budget;
use common\models\Repair;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BudgetController implements the CRUD actions for Budget model.
 */
class BudgetController extends Controller
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
                    'only' => ['index', 'view', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['listBudgets'],
                            'actions' => ['index', 'view'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['createBudgets'],
                            'actions' => ['create'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['updateBudgets'],
                            'actions' => ['update'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['deleteBudgets'],
                            'actions' => ['delete'],
                        ],
                        [
                            "allow" => true,
                            "actions" => ["index", "view", "create", "update", "delete"],
                            "matchCallback" => function ($rule, $action) {
                                return $action->controller->findModel(\Yii::$app->request->get('id'))->repairman_id === \Yii::$app->user->id;
                            },
                        ],
                        [
                            'allow' => false,
                            'roles' => ['?', 'client'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Budget models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (isset(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id)['repairTechnician'])) {
            $dataProvider = new ActiveDataProvider([
                'query' => Budget::find()->where(['user_id' => \Yii::$app->user->id]),
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Budget::find(),
                /*
                'pagination' => [
                    'pageSize' => 50
                ],
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_DESC,
                    ]
                ],
                */
            ]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Budget model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Budget model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Budget();

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->date = date('Y-m-d');
            $model->time = date('H:i:s');
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            dd($model->errors);
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'repairs' => Repair::find()->all(),
            'repairTechnicians' => User::getRepairTechnicians(),
        ]);
    }

    /**
     * Updates an existing Budget model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'repairs' => Repair::getRepairs(),
            'repairTechnicians' => User::getRepairTechnicians(),
        ]);
    }

    /**
     * Deletes an existing Budget model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Budget model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Budget the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Budget::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
