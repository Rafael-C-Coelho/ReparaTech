<?php

use common\models\Budget;
use common\models\Repair;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Repair $model */
/** @var common\models\User[] $clients */
/** @var common\models\User[] $repairTechnicians */

$this->title = 'Update Repair: #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="repair-update">
    <?= $this->render('_form', [
        'model' => $model,
        'repairTechnicians' => $repairTechnicians,
        'clients' => $clients,
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
