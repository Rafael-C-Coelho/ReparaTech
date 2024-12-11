<?php

use common\models\Budget;
use common\models\Repair;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Repair $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\User[] $repairTechnicians */
/** @var common\models\User[] $clients */

?>

<div class="repair-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hours_spent_working')->textInput(["type" => "number"]) ?>

    <?= $form->field($model, 'device')->dropDownList(['Computer' => 'Computer', 'Phone' => 'Phone', 'Tablet' => 'Tablet', 'Wearable' => 'Wearable',], ['prompt' => '']) ?>

    <?= $form->field($model, 'progress')->dropDownList(['Created' => 'Created', 'Pending Acceptance' => 'Pending Acceptance', 'Denied' => 'Denied', 'In Progress' => 'In Progress', 'Completed' => 'Completed',]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php if (isset(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id)["repairTechnician"])) { ?>
        <?= $form->field($model, 'repairman_id')->hiddenInput(["value" => Yii::$app->user->id])->label(false) ?>
    <?php } else { ?>
        <?= $form->field($model, 'repairman_id')->dropDownList($repairTechnicians) ?>
    <?php } ?>

    <?= $form->field($model, 'client_id')->dropDownList($clients) ?>

    <?php if ($model->progress !== Repair::STATUS_COMPLETED && $model->progress !== Repair::STATUS_DENIED) { ?>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
