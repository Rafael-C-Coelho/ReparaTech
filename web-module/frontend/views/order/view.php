<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Sale $model */

$this->title = "Order #" . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order">
    <div class="order-view">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
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
                        return count($model->saleProducts);
                    }
                ],
                [
                    'label' => 'Invoice',
                    'format' => 'raw',
                    'value' => function($model){
                        return Html::a('Invoice', ['order/download-invoice', 'id' => $model->invoice_id],
                        ['class' => 'btn btn-warning',
                         'title' => 'Download Invoice',
                            'download' => true]);
                    }
                ]
            ],
        ]) ?>

        <div>
            <h3>Sale products</h3>
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                [
                    'label' => 'Product Name',
                    'value' => function ($model) {
                        return $model->product->name;
                    },
                ],
                [
                    'label' => 'Product Price',
                    'value' => function ($model) {
                        return Yii::$app->formatter->asCurrency($model->product->price, 'EUR');
                    },
                ],
                [
                    'label' => 'Product Price',
                    'value' => function ($model) {
                        return $model->quantity;
                    },
                ],
            ],
        ]) ?>
    </div>
    <a href="<?= \yii\helpers\Url::to(['order/index']) ?>" type="button" style="background-color: #FFD333;"  class="btn btn-primary">
        <strong>Back</strong>
    </a>

</div>
