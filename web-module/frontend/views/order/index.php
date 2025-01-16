<?php

/** @var \common\models\Sale $model */
/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var \yii\web\View $this */

use yii\bootstrap4\Html;
use yii\grid\GridView;

$this->title = 'Orders';
?>

<div>
    <div>
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    </div>
    <div>
        <div class="site-orders">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    //'client_id',
                    'status',
                    [
                        'label' => 'Total Order', //serve para ir buscar o preço total às faturas
                        'value' => function ($model) {
                            return Yii::$app->formatter->asCurrency($model->invoice->total, 'EUR'); //serve para formatar o valor para euro
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Products',
                        'value' => function ($model) {
                            $productNames = array_map(function ($saleProduct){
                                return $saleProduct->product->name;
                            }, $model->saleProducts);

                            return implode('<br>', $productNames);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Product Quantity',
                        'value' => function ($model){
                            $quantity = 0;
                            foreach ($model->saleProducts as $saleProduct){
                                $quantity += $saleProduct->quantity;
                            }
                            return $quantity;
                        } 
                    ],
                    ['class' => 'yii\grid\ActionColumn', 'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('View', $url, [
                                    'class' => 'btn btn-warning',
                                    'color' => '',
                                    'title' => 'View',
                                ]);
                            },
                        ]
                    ]
                ],
            ]) ?>
        </div>
    </div>

