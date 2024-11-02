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
 * ManagerController implements the CRUD actions for User model.
 */
class ManagerController extends Controller
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
                            "actions" => ["index", "view", "create", "update", "delete", "toggle-status"],
                            "allow" => true,
                            "roles" => ["storeOwner"],
                        ],
                        [
                            "actions" => ["view", "update"],
                            "allow" => true,
                            "roles" => ["manager"],
                            "matchCallback" => function ($rule, $action) {
                                return Yii::$app->user->id == Yii::$app->request->get('id');
                            }
                        ],
                        [
                            "allow" => false,
                            "roles" => ["?"]
                        ]
                    ]
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Filter users with the "manager" role
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()
                ->innerJoin('auth_assignment', 'auth_assignment.user_id = user.id')
                ->where(['auth_assignment.item_name' => 'manager']),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    // Action to view a single user's details
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    // Action to create a new user
    public function actionCreate()
    {
        $model = new User();

        $model->setScenarioBasedOnRole("manager");
        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->generateEmailVerificationToken();
            $model->status = User::STATUS_ACTIVE;
            $model->name = Yii::$app->request->post('User')['name'];
            $model->save();

            $auth = Yii::$app->authManager;
            $auth->assign($auth->getRole('manager'), $model->id);

            Yii::$app->session->setFlash('success', 'Manager created successfully.');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // Action to update an existing user
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Set scenario based on the user's assigned role
        $model->setScenarioBasedOnRole("manager");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Manager updated successfully.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionToggleStatus($id)
    {
        $model = $this->findModel($id);
        if ((int)($model->status) !== 10) {
            $model->status = User::STATUS_ACTIVE;
        } else {
            $model->status = User::STATUS_INACTIVE;
        }
        $model->save();
        return $this->redirect(['view', 'id' => $id]);
    }

    // Action to delete a user
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'User deleted successfully.');
        return $this->redirect(['index']);
    }

    // Method to find a user model by its primary key
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested user does not exist.');
    }
}
