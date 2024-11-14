<?php

use common\models\Budget;
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

$dataProviderBudgets = new yii\data\ActiveDataProvider([
    'query' => $model->getBudgets(),
]);
$dataProviderInvoices = new yii\data\ActiveDataProvider([
    'query' => $model->getInvoices(),
]);
?>
<div class="repair-update">
    <?= $this->render('_form', [
        'model' => $model,
        'repairTechnicians' => $repairTechnicians,
        'clients' => $clients,
    ]) ?>

    <div class="d-flex my-2 justify-content-between align-items-center">
        <h6>Related budgets</h6>
        <?= Html::a('Create Budget', ['budget/create', 'repair_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </div>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProviderBudgets,
        'columns' => [
            'id',
            'value',
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
        <h6>Related invoices</h6>
        <?= Html::a('Create Invoice', ['invoice/create', "repair_id" => $model->id], ['class' => 'btn btn-success']) ?>
    </div>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProviderInvoices,
        'columns' => [
            'id',
            'value',
            'date:date',
            'time:time',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Budget $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>



</div>
