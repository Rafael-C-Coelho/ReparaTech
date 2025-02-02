<?php
// views/user/_form.php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="manager-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'type' => 'email']) ?>
    <?php if(\Yii::$app->user->can('storeOwner') && \Yii::$app->controller->action->id === "create"):?>
        <?=$form->field($model, 'password')->passwordInput(); ?>
    <?php endif; ?>
    <?php
    // Conditionally display fields based on the user's scenario (role)
    if ($model->scenario === User::SCENARIO_MANAGER): ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php elseif ($model->scenario === User::SCENARIO_STORE_OWNER): ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php elseif ($model->scenario === User::SCENARIO_CLIENT): ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'nif')->textInput(["maxlength" => true]) ?>
        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'contact')->textInput(['maxlength' => true, 'type' => 'phone']) ?>

    <?php elseif ($model->scenario === User::SCENARIO_REPAIR_TECHNICIAN): ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'value')->textInput(['maxlength' => true, 'type' => 'number']) ?>

    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
