<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Invoice $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\User[] $clients */
/** @var common\models\Repair[] $repairs */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'date')->textInput(["type" => "date"])?>
    <?= $form->field($model, 'time') ->textInput(["type" => "time"])?>
    <?= $form->field($model,'total') ->textInput(["type" => "decimal"])?>
    <?php if (isset(Yii::$app->request->queryParams['repair_id'])) { ?>
        <?= $form->field($model, 'repair_id')->hiddenInput(["value" => Yii::$app->request->queryParams['repair_id']])->label(false) ?>
    <?php } else { ?>
        <?= $form->field($model, 'repair_id')->dropDownList(ArrayHelper::map($repairs, 'id', 'id')) ?>
    <?php } ?>
    <?= $form->field($model, 'client_id')->dropDownList($clients)?>

    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    </div>

    <?php $form = ActiveForm::end(); ?>
</div>
