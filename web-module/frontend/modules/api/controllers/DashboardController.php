<?php

namespace frontend\modules\api\controllers;

use common\models\Product;
use common\models\Sale;
use common\models\SaleProduct;
use frontend\modules\api\helpers\AuthBehavior;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\rest\Controller;

/**
 * Default controller for the `api` module
 */
class DashboardController extends Controller
{
    public $user = null;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => AuthBehavior::class,
                'except' => ['latest', 'most-sold'],
            ],
        ]);
    }

    public function actions()
    {
        $actions = parent::actions();
        return $actions;
    }

    protected function verbs()
    {
        return array_merge(parent::verbs(),
            [
                'latest' => ['GET'],
                'mostSold' => ['GET'],
            ]
        );
    }

    public function actionLatest()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        $products = $dataProvider->getModels();
        if ($products) {
            return ['products' => $products, "status" => "success"];
        }
        return ['message' => 'Product not found', "status" => "error"];
    }

    public function actionMostSold()
    {
        $products = Product::find()
            ->select(['products.*', 'SUM(sales_has_products.quantity) AS total_quantity'])
            ->joinWith('saleProducts') // Assuming 'saleProducts' is the relation in Product
            ->groupBy(['products.id', 'products.name'])
            ->orderBy(['total_quantity' => SORT_DESC])
            ->limit(8)
            ->asArray()
            ->all();

        $products = array_filter(array_map(function ($product) {
            if ($product['total_quantity'] > 0) {
                return [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                ];
            }
            return null;
        }, $products), function ($v) { return !is_null($v); });

        return ['sales' => $products, "status" => "success"];
    }
}
