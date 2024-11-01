<?php

/** @var yii\web\View $this */
/** @var \common\models\Part $model */

$this->title = Yii::t('app', 'Create Part');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="part-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
