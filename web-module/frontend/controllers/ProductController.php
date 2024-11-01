<?php

namespace frontend\controllers;

use common\models\Product;
use common\models\ProductCategory;
use yii\data\Pagination;

class ProductController extends \yii\web\Controller
{
    public function actionDetails($id)
    {
        $product = Product::findOne($id);
        if (!$product) {
            throw new \yii\web\NotFoundHttpException('Product not found');
        }

        $isFavorite = false;
        if (!\Yii::$app->user->isGuest) {
            $isFavorite = \Yii::$app->user->identity->hasFavoriteProduct($product);
        }

        return $this->render('product-details', [
            'model' => $product,
            'isFavorite' => $isFavorite,
        ]);
    }

    public function actionFavorites()
    {
        return $this->render('favorites');
    }

    public function actionToggleFavorites()
    {
        if (!\Yii::$app->request->isPost) {
            throw new \yii\web\BadRequestHttpException('Only POST requests are allowed');
        }
        if (\Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', 'You must be logged in to add products to favorites');
            return $this->redirect(['site/login']);
        }

        $productId = \Yii::$app->request->post('productId');
        $product = Product::findOne($productId);
        if (!$product) {
            \Yii::$app->session->setFlash('error', 'Product not found');
        }

        $user = \Yii::$app->user->identity;
        if ($user->hasFavoriteProduct($product)) {
            $user->removeFavoriteProduct($product);
        } else {
            $user->addFavoriteProduct($product);
        }

        return $this->redirect(['product/details', 'id' => $productId]);
    }

    public function actionManageCart()
    {
        if (!\Yii::$app->request->isPost) {
            throw new \yii\web\BadRequestHttpException('Only POST requests are allowed');
        }

        $productId = (int)\Yii::$app->request->post('productId');
        $quantity = (int)\Yii::$app->request->post('quantity');
        $product = Product::findOne($productId);
        if (!$product) {
            \Yii::$app->session->setFlash('error', 'Product not found');
        }

        $cart = \Yii::$app->session->get('cart', []);
        if (sizeof($cart) > 0) {
            foreach ($cart as $item) {
                if ($item['product_id'] == $productId) {
                    $item['quantity'] = (int)$item['quantity'] + (int)$quantity;
                    \Yii::$app->session->set('cart', $cart);
                    return $this->redirect(['product/details', 'id' => $productId]);
                }
            }
        } else {
            \Yii::$app->session->set('cart', [
                [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]
            ]);
        }

        return $this->redirect(['product/details', 'id' => $productId]);
    }

    public function actionShop($category_id = "")
    {
        $query = Product::find();

        // Apply category filter if a category ID is provided
        if ($category_id) {
            $query->andWhere(['category_id' => $category_id]);
            $selected_category = ProductCategory::findOne($category_id);

            // Check if the selected category exists
            if (!$selected_category) {
                throw new \yii\web\NotFoundHttpException('Category not found');
            }
        } else {
            $selected_category = -1; // For the "All categories" case
        }

        // Set up pagination for the product query
        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 9, // Set the number of products per page
        ]);

        $products = $query->offset($pagination->offset)
            # ->limit($pagination->limit)
            ->limit($pagination->limit)
            ->all();

        // Retrieve all categories for the filter
        $categories = ProductCategory::find()->all();

        return $this->render('shop', [
            'products' => $products,
            'categories' => $categories,
            'selected_category' => $selected_category,
            'pagination' => $pagination,
        ]);
    }

}
