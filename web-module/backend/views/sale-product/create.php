<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SaleProduct $model */

$this->title = 'Create Sale Product';
$this->params['breadcrumbs'][] = ['label' => 'Sale Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
