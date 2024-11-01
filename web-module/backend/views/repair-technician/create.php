<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = Yii::t('app', 'Create Repair Technician');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Repair Technicians'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repair-technician-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
