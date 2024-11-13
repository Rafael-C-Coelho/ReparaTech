<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\RepairPart $model */

$this->title = 'Update Repair Part: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Repair Parts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="repair-part-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
