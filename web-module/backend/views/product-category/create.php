<?php

/** @var yii\web\View $this */
/** @var \common\models\ProductCategory $model */

$this->title = Yii::t('app', 'Create Product Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
