<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Sale $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sale-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'address',
            'zip_code',
            'status',
            'client_id',
            'invoice_id',
        ],
    ]) ?>

    <h2>Products</h2>
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getSaleProducts(),
        ]),
        'columns' => [
            'product.name',
            'quantity',
            'total_price',
        ],
    ]) ?>

</div>
