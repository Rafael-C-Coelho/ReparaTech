<?php

use common\models\ProductCategory;
use common\models\Supplier;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \common\models\Product $model */
/** @var \common\models\Supplier $supplies */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'type' => 'number', 'min' => 0.01, 'step' => 0.01]) ?>

    <?= $form->field($model, 'stock')->textInput(['type' => 'number', 'min' => 0]) ?>

    <?= $form->field($model, 'supplier_id')->dropDownList(
        ArrayHelper::map(Supplier::find()->all(), 'id', 'name'),
        ['prompt' => 'Select Supplier']
    ) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(ProductCategory::find()->all(), 'id', 'name'),
        ['prompt' => 'Select category']
    ) ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
