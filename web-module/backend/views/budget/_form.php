<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Budget $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\Repair[] $repairs */
/** @var common\models\User[] $repairTechnicians */
?>

<div class="budget-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true, "type" => "number"]) ?>

    <?= $form->field($model, 'repair_id')->dropDownList(ArrayHelper::map($repairs, 'id', 'id')) ?>

    <?php if (isset(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id)["repairTechnician"])) { ?>
        <?= $form->field($model, 'repairman_id')->hiddenInput(["value" => Yii::$app->user->id])->label(false) ?>
    <?php } else { ?>
        <?= $form->field($model, 'repairman_id')->dropDownList($repairTechnicians) ?>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
