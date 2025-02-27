<?php

namespace backend\controllers;

use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RepairTechnicianController implements the CRUD actions for User model.
 */
class RepairTechnicianController extends Controller
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
                    'rules' => [
                        [
                            "actions" => ["index", "view", "create", "update"],
                            "allow" => true,
                            "roles" => ["storeOwner", "manager"],
                        ],
                        [
                            "actions" => ["view", "update"],
                            "allow" => true,
                            "roles" => ["repairTechnician"],
                            "matchCallback" => function ($rule, $action) {
                                return \Yii::$app->user->id == \Yii::$app->request->get('id');
                            }
                        ],
                        [
                            "allow" => false,
                            "roles" => ["?"]
                        ]
                    ]
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()
                ->innerJoin('auth_assignment', 'auth_assignment.user_id = user.id')
                ->where(['auth_assignment.item_name' => 'repairTechnician']),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

        $model->setScenarioBasedOnRole("repairTechnician");
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->setPassword($model->password);
                $model->generateAuthKey();
                $model->generateEmailVerificationToken();
                $model->status = User::STATUS_ACTIVE;
                $model->save();
                $auth = \Yii::$app->authManager;
                $auth->assign($auth->getRole('repairTechnician'), $model->id);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->setScenarioBasedOnRole("repairTechnician");
        if ($this->request->isPost && $model->load($this->request->post())) {
            if (!empty($model->password)) {
                $model->setPassword($model->password);
            }
            $model->generateAuthKey();
            $model->generateEmailVerificationToken();
            $model->status = User::STATUS_ACTIVE;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
