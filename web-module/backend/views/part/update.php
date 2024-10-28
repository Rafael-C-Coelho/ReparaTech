<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Part $model */

$this->title = Yii::t('app', 'Update Part: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="part-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
