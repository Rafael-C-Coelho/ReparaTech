<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = Yii::t('app', 'Create Manager');
if (Yii::$app->user->can('createManagers')) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Managers'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manager-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
