<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Budget $model */
/** @var common\models\Repair[] $repairs */
/** @var common\models\User[] $repairTechnicians */

$this->title = 'Update Budget: #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="budget-update">
    <?= $this->render('_form', [
        'model' => $model,
        'repairs' => $repairs,
        'repairTechnicians' => $repairTechnicians,
    ]) ?>

</div>
