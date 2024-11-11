<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SaleProduct $model */

$this->title = 'Update Sale Product: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sale Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sale-product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
