<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->params['breadcrumbs'][] = ['label' => 'Personal Information', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Informations';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, //
    ]) ?>

</div>
