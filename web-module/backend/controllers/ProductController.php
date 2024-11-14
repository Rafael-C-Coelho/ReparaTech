<?php

namespace backend\controllers;

use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\Url;

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
                if ($image) {
                    // Generate unique filename
                    $fileName = 'product_' . $model->id . '_' . time() . '.' . $image->extension;
                    
                    // Create assets/products directory in both frontend and backend if they don't exist
                    $backendPath = \Yii::getAlias('@backend/web/assets/products');
                    $frontendPath = \Yii::getAlias('@frontend/web/assets/products');
                    
                    if (!file_exists($backendPath)) {
                        mkdir($backendPath, 0777, true);
                    }
                    if (!file_exists($frontendPath)) {
                        mkdir($frontendPath, 0777, true);
                    }
                    
                    // Save file in both locations
                    $backendFilePath = $backendPath . '/' . $fileName;
                    $frontendFilePath = $frontendPath . '/' . $fileName;
                    
                    if ($image->saveAs($backendFilePath)) {
                        copy($backendFilePath, $frontendFilePath);
                        // Store the URL in the model
                        $model->image = Url::to('@web/assets/products/' . $fileName);
                        $model->save();
                    }
                }
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
        $oldImage = $model->image;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $image = UploadedFile::getInstance($model, 'image');
            
            if ($image) {
                // Generate unique filename
                $fileName = 'product_' . $model->id . '_' . time() . '.' . $image->extension;
                
                // Create assets/products directory in both frontend and backend if they don't exist
                $backendPath = \Yii::getAlias('@backend/web/assets/products');
                $frontendPath = \Yii::getAlias('@frontend/web/assets/products');
                
                if (!file_exists($backendPath)) {
                    mkdir($backendPath, 0777, true);
                }
                if (!file_exists($frontendPath)) {
                    mkdir($frontendPath, 0777, true);
                }
                
                // Save file in both locations
                $backendFilePath = $backendPath . '/' . $fileName;
                $frontendFilePath = $frontendPath . '/' . $fileName;
                
                if ($image->saveAs($backendFilePath)) {
                    copy($backendFilePath, $frontendFilePath);
                    
                    // Delete old image if exists from both locations
                    if ($oldImage) {
                        $oldBackendPath = \Yii::getAlias('@backend/web') . str_replace('@web', '', $oldImage);
                        $oldFrontendPath = \Yii::getAlias('@frontend/web') . str_replace('@web', '', $oldImage);
                        
                        if (file_exists($oldBackendPath)) {
                            unlink($oldBackendPath);
                        }
                        if (file_exists($oldFrontendPath)) {
                            unlink($oldFrontendPath);
                        }
                    }
                    
                    // Store the new URL
                    $model->image = Url::to('@web/assets/products/' . $fileName);
                }
            } else {
                $model->image = $oldImage;
            }
            
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
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
        $model = $this->findModel($id);
        
        // Delete associated image file if exists from both locations
        if ($model->image) {
            $backendPath = \Yii::getAlias('@backend/web') . str_replace('@web', '', $model->image);
            $frontendPath = \Yii::getAlias('@frontend/web') . str_replace('@web', '', $model->image);
            
            if (file_exists($backendPath)) {
                unlink($backendPath);
            }
            if (file_exists($frontendPath)) {
                unlink($frontendPath);
            }
        }
        
        $model->delete();

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
