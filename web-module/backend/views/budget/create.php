<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Budget $model */

$this->title = 'Create Budget';
$this->params['breadcrumbs'][] = ['label' => 'Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="budget-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
