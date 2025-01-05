<?php

namespace frontend\modules\api\controllers;

use common\models\Invoice;
use common\models\Product;
use common\models\Sale;
use common\models\SaleProduct;
use Dompdf\Dompdf;
use frontend\modules\api\helpers\AuthBehavior;
use PHPUnit\Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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

    public function actionCart(){
        $request = Yii::$app->request;
        $cart = $request['cart'];
        $productId = $request->post('product_id');
        $quantity = $request->post('quantity');

        $product = Product::findOne($productId);
        if(!$product){
            throw new \Exception('Product not found');
        }

        if(!isset($cart[$productId])){
            $cart[$productId] = 0;
        }

        $cart[$productId] += $quantity;

        return ['cart' => $cart, "status" => "success"];
    }

    public function actionCreate(){
        $request = Yii::$app->request;
        $cart = $request->post('cart', []);
        if(empty($cart)){
            return ['message' => 'Cart is empty', "status" => "error"];
        }

        $transaction = Yii::$app->db->beginTransaction();
        try{
            $sale = new Sale();
            $sale->client_id = Yii::$app->user->id;
            $sale->address = $request->post('address');
            $sale->zip_code = $request->post('zip_code');
            $total = 0;
            $items = [];

            if(!$sale->save()){
                throw new BadRequestHttpException('Error creating sale');
            }

            foreach ($cart as $productDetails){
                $product = Product::findOne($productDetails['product_id']);
                if($product === null){
                    throw new NotFoundHttpException('Product not found');
                }
                $saleProduct = new SaleProduct();
                $saleProduct->sale_id = $sale->id;
                $saleProduct->product_id = $product->id;
                $saleProduct->quantity = $productDetails['quantity'];
                $saleProduct->total_price = $product->price * $productDetails['quantity'];
                $product->stock -= $productDetails['quantity'];

                $items[] = [
                    'name' => $product->name,
                    'quantity' => $productDetails['quantity'],
                    'price' => $product->price,
                ];

                if(!$saleProduct->save()){
                    throw new BadRequestHttpException('Error creating sale product');
                }

                $product->save();
                $total += $product->price * $productDetails['quantity'];
            }
            $items[] = [
                'name' => "Shipping",
                'quantity' => 1,
                'price' => Yii::$app->params['defaultShipping'],
            ];
            $total += Yii::$app->params['defaultShipping'];

            $invoice = new Invoice();
            $invoice->client_id = Yii::$app->user->id;
            $invoice->total = $total;
            $invoice->items = json_encode($items);

            if(!$invoice->save()){
                throw new BadRequestHttpException('Error creating invoice');
            }

            $filePath = $this->generateInvoicePdf($sale, $invoice, $items);
            $invoice->pdf_file = $filePath;
            $invoice->save();

            $sale->invoice_id = $invoice->id;
            $sale->save();

            $transaction->commit();

            return ['status' => 'sucess', 'message' => 'Purchase completed', 'sale_id' => $sale->id, 'invoice_pdf' => Yii::$app->request->hostInfo . $filePath];
        }catch (Exception $e){
            $transaction->rollBack();
            return ['message' => $e->getMessage(), "status" => "error"];
        }
    }

    protected function generateInvoicePdf(Sale $sale, Invoice $invoice, array $items): string{
        $content = $this->renderPartial('@app/views/invoice-sale', [
            'model' => $sale,
            'items' => $items,
            'invoice' => $invoice,
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $path = \Yii::getAlias('@app/web/invoices/');
        FileHelper::createDirectory($path);

        $fileName = 'invoice_' . $invoice->id . '_' . $sale->client_id . '.pdf';
        $filePath = $path . DIRECTORY_SEPARATOR . $fileName;

        file_put_contents($filePath, $dompdf->output());

        return '/uploads/invoices/' . $fileName;
    }

    public function actionZipCode($id){
        $zipCode = Sale::find()->select(['zip_code'])->where(['id' => $id])->scalar();

        if($zipCode !== null){
            return ['zip_code' => $zipCode, "status" => "success"];
        }
        return ['message' => 'Zip code not found', "status" => "error"];
    }

    public function actionProducts($id){
        $saleProducts = SaleProduct::find()->where(['sale_id' => $id])->with(['product'])->all();
        $products = array_map(function($saleProduct){
            return [
                'product_id' => $saleProduct->product_id,
                'quantity' => $saleProduct->quantity,
                'total_price' => $saleProduct->total_price,
                'product' => $saleProduct->product,
            ];
        }, $saleProducts);
        return ['sale_products' => $products, "status" => "success"];
    }
}
