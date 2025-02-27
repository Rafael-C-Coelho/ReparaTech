<?php

/** @var yii\web\View $this */
/** @var \common\models\Supplier $model */

$this->title = Yii::t('app', 'Update Supplier: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="supplier-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
