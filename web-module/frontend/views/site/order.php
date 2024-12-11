<?php

/** @var \common\models\SaleProduct $model */
/** @var \yii\data\ActiveDataProvider $dataProvider */

use yii\bootstrap4\Html;
use yii\grid\GridView;

$this->title = 'Orders';
?>

<div>
    <div>
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    </div>
    <div>
        <p>Here you can see all your orders:</p>
    <div class="site-orders">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'sale_id',
                'product_id',
                'quantity',
                'total_price',
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



