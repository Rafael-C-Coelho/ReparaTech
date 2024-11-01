<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = Yii::t('app', 'Update User: {name}', [
    'name' => $model->name,
]);
if (Yii::$app->user->can('createManagers')) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Managers'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
