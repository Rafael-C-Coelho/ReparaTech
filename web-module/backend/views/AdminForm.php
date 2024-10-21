<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var ActiveForm $form */
?>
<div class="AdminForm">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'role') ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'nif') ?>
        <?= $form->field($model, 'contact') ?>
        <?= $form->field($model, 'address') ?>
        <?= $form->field($model, 'value') ?>
    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- AdminForm -->
