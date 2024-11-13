<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Repair $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\User[] $repairTechnicians */
/** @var common\models\User[] $clients */
?>

<div class="repair-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'device')->dropDownList([ 'Computer' => 'Computer', 'Phone' => 'Phone', 'Tablet' => 'Tablet', 'Wearable' => 'Wearable', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'progress')->dropDownList([ 'Created' => 'Created', 'Pending Acceptance' => 'Pending Acceptance', 'Denied' => 'Denied', 'In Progress' => 'In Progress', 'Completed' => 'Completed', ], ['value' => 'Created']) ?>

    <?php if (isset(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id)["repairTechnician"])) { ?>
        <?= $form->field($model, 'repairman_id')->hiddenInput(["value" => Yii::$app->user->id]) ?>
    <?php } else { ?>
        <?= $form->field($model, 'repairman_id')->dropDownList($repairTechnicians) ?>
    <?php } ?>

    <?= $form->field($model, 'client_id')->dropDownList($clients) ?>

    <?php foreach ()

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
