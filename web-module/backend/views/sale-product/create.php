<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SaleProduct $model */

$this->title = 'Create Sale Product';
$this->params['breadcrumbs'][] = ['label' => 'Sale Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-product-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
