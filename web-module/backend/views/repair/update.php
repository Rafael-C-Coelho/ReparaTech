<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Repair $model */

$this->title = 'Update Repair: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="repair-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
