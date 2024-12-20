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
                    ['class' => 'yii\grid\SerialColumn'],
                    'client_id',
                    [
                        'label' => 'Client Name',
                        'value' => function ($model) {
                            return $model->client->name;
                        },
                    ],
                    [
                        'label' => 'Total Order', //serve para ir buscar o preço total às faturas
                        'value' => function ($model) {
                            return Yii::$app->formatter->asCurrency($model->invoice->total, 'EUR'); //serve para formatar o valor para euro
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Product Quantity',
                        'value' => function ($model){
                            return count($model->saleProduct);
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

