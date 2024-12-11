<?php

use common\models\Budget;
use common\models\Repair;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Repair $model */

$this->title = "Repair #" . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


\yii\web\YiiAsset::register($this);
?>
<div class="repair-view">
    <p>
        <?php if ($model->progress !== Repair::STATUS_COMPLETED && $model->progress !== Repair::STATUS_DENIED) { ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'device',
            'progress',
            'hours_spent_working',
            'repairman_id',
            'client_id',
            'description',
        ],
    ]) ?>

    <div class="d-flex my-2 justify-content-between align-items-center">
        <h6>Related budgets</h6>
        <?php if ($model->progress !== Repair::STATUS_COMPLETED) { ?>
        <?= Html::a('Create Budget', ['budget/create', 'repair_id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProviderBudgets,
        'columns' => [
            'id',
            'value',
            'status',
            'date:date',
            'time:time',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Budget $budget, $key, $index, $column) {
                    return Url::toRoute(["budget/" . $action, 'id' => $budget->id]);
                }
            ],
        ],
    ]); ?>

    <div class="d-flex my-2 justify-content-between align-items-center">
        <h6>Related comments</h6>
    </div>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProviderComments,
        'columns' => [
            'id',
            'description',
            'status',
            'date:date',
            'time:time',
            [
                'class' => ActionColumn::className(),
            ],
        ],
    ]); ?>

</div>
