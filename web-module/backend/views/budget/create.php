<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Budget $model */
/** @var common\models\Repair[] $repairs */
/** @var common\models\User[] $repairTechnicians */

$this->title = 'Create Budget';
$this->params['breadcrumbs'][] = ['label' => 'Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="budget-create">
    <?= $this->render('_form', [
        'model' => $model,
        'repairs' => $repairs,
        'repairTechnicians' => $repairTechnicians,
    ]) ?>

</div>
