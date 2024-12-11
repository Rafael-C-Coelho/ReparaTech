<?php

/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\User $model */
/** @var \yii\web\View $this */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Personal Information';
?>

<form method="post">
    <div class="mb-3">
        <div class="mt-3 mb-5">
            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="form-label">
            <?php $form = ActiveForm::begin(['id' => 'PersonalInformation']); ?>
            <?= $form->field($model, 'username')->textInput() ?>
            <?= $form->field($model, 'address')->textInput() ?>
            <?= $form->field($model,'nif')->textInput(['maxlength' => true, "type" => "number"])?>
            <?= $form->field($model, 'contact')->textInput() ?>
            <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
        </div>
        <div class="form-group text-left">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'Send-button']) ?>

            <a href="<?= \yii\helpers\Url::to(['site/painelClient']) ?>" type="button" style="background-color: #FFD333;"  class="btn btn-primary">
                <strong>Back</strong>
            </a>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</form>
