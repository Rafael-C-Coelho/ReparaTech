<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\BudgetPart $model */

$this->title = 'Update Budget Part: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Budget Parts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="budget-part-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
