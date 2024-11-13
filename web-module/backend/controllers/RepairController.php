<?php

namespace backend\controllers;

use common\models\Repair;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
                    'only' => ['index', 'view', 'create', 'update', 'delete'],
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
                            'roles' => ['deleteRepairs'],
                            'actions' => ['delete'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
                            'matchCallback' => function ($rule, $action) {
                                return $action->controller->findModel(\Yii::$app->request->get('id'))->repairman_id === \Yii::$app->user->id;
                            },
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
     * Lists all Repair models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (isset(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id)['repairman'])) {
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
            if ($model->load($this->request->post()) && $model->save()) {
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Repair model.
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
