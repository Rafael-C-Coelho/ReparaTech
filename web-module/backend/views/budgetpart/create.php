<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\BudgetPart $model */

$this->title = 'Create Budget Part';
$this->params['breadcrumbs'][] = ['label' => 'Budget Parts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="budget-part-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
