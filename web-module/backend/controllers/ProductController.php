<?php

namespace backend\controllers;

use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
                            'roles' => ['listProducts'],
                            'actions' => ['index', 'view'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['createProducts'],
                            'actions' => ['create'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['updateProducts'],
                            'actions' => ['update'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['deleteProducts'],
                            'actions' => ['delete'],
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
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

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $image = UploadedFile::getInstance($model, 'image');
                $imageData = file_get_contents($image->tempName);
                $base64 = base64_encode($imageData);

                // Determine the MIME type prefix based on file extension
                $extension = strtolower($image->extension);
                $mimeType = '';

                // Set the appropriate MIME type
                if (in_array($extension, ['jpg', 'jpeg'])) {
                    $mimeType = 'data:image/jpeg;base64,';
                } elseif ($extension === 'png') {
                    $mimeType = 'data:image/png;base64,';
                } elseif ($extension === 'gif') {
                    $mimeType = 'data:image/gif;base64,';
                }
                $model->image = $mimeType . $base64;
                $model->save();

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
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->load($this->request->post());
            if (\Yii::$app->request->post('Product')['image'] === null || \Yii::$app->request->post('Product')['image'] === '') {
                $model->image = $model->getOldAttribute('image');
            } else {
                $image = UploadedFile::getInstance($model, 'image');
                $imageData = file_get_contents($image->tempName);
                $base64 = base64_encode($imageData);

                // Determine the MIME type prefix based on file extension
                $extension = strtolower($image->extension);
                $mimeType = '';

                // Set the appropriate MIME type
                if (in_array($extension, ['jpg', 'jpeg'])) {
                    $mimeType = 'data:image/jpeg;base64,';
                } elseif ($extension === 'png') {
                    $mimeType = 'data:image/png;base64,';
                } elseif ($extension === 'gif') {
                    $mimeType = 'data:image/gif;base64,';
                }
                $model->image = $mimeType . $base64;
            }
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
