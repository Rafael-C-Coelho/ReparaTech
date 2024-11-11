<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\BudgetPart $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="budget-part-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'budget_id')->textInput() ?>

    <?= $form->field($model, 'part_id')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
