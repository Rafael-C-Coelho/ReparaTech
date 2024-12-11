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

    <?= $form->field($model, 'client_id')->dropDownList($clients)?>

    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    </div>

    <?php $form = ActiveForm::end(); ?>
</div>
