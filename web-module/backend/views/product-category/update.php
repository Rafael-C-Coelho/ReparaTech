<?php

/** @var yii\web\View $this */
/** @var \common\models\ProductCategory $model */

$this->title = Yii::t('app', 'Update Product Category: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-category-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
