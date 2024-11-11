<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\RepairPart $model */

$this->title = 'Create Repair Part';
$this->params['breadcrumbs'][] = ['label' => 'Repair Parts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repair-part-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
