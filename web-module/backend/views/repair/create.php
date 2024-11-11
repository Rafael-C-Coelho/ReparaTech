<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Repair $model */

$this->title = 'Create Repair';
$this->params['breadcrumbs'][] = ['label' => 'Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repair-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
