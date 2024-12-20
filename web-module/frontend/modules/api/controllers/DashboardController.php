<?php

namespace frontend\modules\api\controllers;

use common\models\Product;
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
        $salesQuery = SaleProduct::find()
            ->select(['product_id', 'SUM(quantity) as total'])
            ->groupBy('product_id')
            ->orderBy(['total' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $salesQuery,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        $sales = $dataProvider->getModels();
        $products = [];
        foreach ($sales as $sale) {
            $product = Product::findOne($sale['product_id']);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'total' => $sale['total'],
                ];
            }
        }
        return ['sales' => $products, "status" => "success"];
    }
}
