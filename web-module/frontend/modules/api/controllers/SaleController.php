<?php

namespace frontend\modules\api\controllers;

use common\models\Invoice;
use common\models\Product;
use common\models\Sale;
use common\models\SaleProduct;
use frontend\modules\api\helpers\AuthBehavior;
use PHPUnit\Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\rest\ActiveController;

class SaleController extends ActiveController
{
    public $modelClass = 'common\models\Sale';
    public $user = null;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            $behaviors['sale'] = [
                'class' => AuthBehavior::class,
            ],
        ]);
    }

    public function actions(){
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        return $actions;
    }

    protected function verbs(){
        return array_merge(parent::verbs(), [
            'latest' => ['GET'],
        ]);
    }

    public function checkAccess($action, $model = null, $params = []){
        if ($action === 'create' || $action === 'update' || $action === 'delete') {
            if (\Yii::$app->user->identity->hasRole('admin' || 'manager' || 'technician')) {
                throw new \yii\web\ForbiddenHttpException('You can only view sales.');
            }
        }
    }

    public function actionIndex(){

        $activeData = new ActiveDataProvider([
            'query' => Sale::find()->with('saleProducts'),
        ]);


        return ['sales' => $activeData, 'total' => $activeData->getTotalCount(), "status" => "success"];
    }

    public function actionView($id){
        $sale = Sale::find()->with('saleProducts')->where(['id' => $id])->one();
        if ($sale) {
            return ['sale' => $sale, "status" => "success"];
        }
        return ['message' => 'Sale not found', "status" => "error"];
    }

    public function actionCreate(){
        $postData = \Yii::$app->request->post();
        $user = \Yii::$app->user->identity;
        $sale = new Sale();
        $sale->client_id = $user->id;
        $sale->address = $postData['address'];
        $sale->zip_code = $postData['zip_code'];

        if ($sale->save()) {
            $total = 0;
            $totalItems = [];

            if(isset($postData['sale_products'])){
                foreach ($postData['sale_products'] as $productData){
                    $saleProduct = new SaleProduct();
                    $product = Product::findOne($productData['product_id']);

                    if($product === null){
                        return ['message' => 'Product not found', 'status' => 'error'];
                    }

                    $saleProduct->sale_id = $sale->id;
                    $saleProduct->product_id = $product->id;
                    $saleProduct->quantity = $productData['quantity'];
                    $saleProduct->total_price = $product->price;

                    $totalItems[] = [
                        'name' => $product->name,
                        'quantity' => $productData['quantity'],
                        'total_price' => $product->price,
                    ];
                    if(!$saleProduct->save()){
                        return ['message' => 'SaleProduct not created', 'errors' => $product->errors, "status" => "error"];
                    }

                    $total += $product->price * $productData['quantity'];
                }
            }

            $invoice = new Invoice();
            $invoice->client_id = $user->id;
            $invoice->total = $total;
            $invoice->items = json_encode($totalItems);

            if($invoice->save()) {
                $sale->invoice_id = $invoice->id;
                if (!$sale->save()) {
                    return ['message' => 'Sale not created', 'errors' => $sale->errors, "status" => "error"];
                }
                return ['sale' => $sale, 'invoice_id' => $invoice->id, "status" => "success"];
            }
        }
        if (!$sale->save()) {
            return ['errors' => $sale->errors, 'status' => 'error', 'message' => 'Sale not created'];
        }
        return ['message' => 'Sale not created', "status" => "error"];
    }

}
