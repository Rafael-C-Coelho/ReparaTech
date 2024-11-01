<?php

/** @var yii\web\View $this */
/** @var \common\models\Supplier $model */

$this->title = Yii::t('app', 'Create Supplier');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
