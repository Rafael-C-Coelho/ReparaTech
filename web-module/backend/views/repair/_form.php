<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Repair $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="repair-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'device')->dropDownList([ 'Computer' => 'Computer', 'Phone' => 'Phone', 'Tablet' => 'Tablet', 'Wearable' => 'Wearable', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'progress')->dropDownList([ 'Created' => 'Created', 'Pending Acceptance' => 'Pending Acceptance', 'Denied' => 'Denied', 'In Progress' => 'In Progress', 'Completed' => 'Completed', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'repairman_id')->textInput() ?>

    <?= $form->field($model, 'client_id')->textInput() ?>

    <?= $form->field($model, 'budget_id')->textInput() ?>

    <?= $form->field($model, 'invoice_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
