<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->name;
if (Yii::$app->user->can('createManagers')) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Managers'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="manager-view">
    <p>
        <?= Yii::$app->authManager->checkAccess(Yii::$app->user->id, "updateManagers") || Yii::$app->authManager->getAssignment("manager", Yii::$app->user->id) ? Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) : '' ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'name',
            'email:email',
        ],
    ]) ?>

</div>
