<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = "Repair Technician";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Repair Technicians'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="repair-technician-view">


    <p>
        <?= Yii::$app->user->can('updateRepairTechnician') || $model->id === Yii::$app->user->id ? Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) : '' ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            'status',
            'name',
            'value',
        ],
    ]) ?>

</div>
