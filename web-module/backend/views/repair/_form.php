<?php

use common\models\Budget;
use common\models\Repair;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Repair $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\User[] $repairTechnicians */
/** @var common\models\User[] $clients */
/** @var yii\data\ActiveDataProvider  */

$dataProviderBudgets = new yii\data\ActiveDataProvider([
    'query' => $model->getBudgets(),
]);
$dataProviderInvoices = new yii\data\ActiveDataProvider([
    'query' => $model->getInvoices(),
]);


?>

<div class="repair-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'device')->dropDownList(['Computer' => 'Computer', 'Phone' => 'Phone', 'Tablet' => 'Tablet', 'Wearable' => 'Wearable',], ['prompt' => '']) ?>

    <?= $form->field($model, 'progress')->dropDownList(['Created' => 'Created', 'Pending Acceptance' => 'Pending Acceptance', 'Denied' => 'Denied', 'In Progress' => 'In Progress', 'Completed' => 'Completed',]) ?>

    <?php if (isset(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id)["repairTechnician"])) { ?>
        <?= $form->field($model, 'repairman_id')->hiddenInput(["value" => Yii::$app->user->id])->label(false) ?>
    <?php } else { ?>
        <?= $form->field($model, 'repairman_id')->dropDownList($repairTechnicians) ?>
    <?php } ?>

    <?= $form->field($model, 'client_id')->dropDownList($clients) ?>

    <div class="d-flex my-2 justify-content-between align-items-center">
        <h6>Related budgets</h6>
        <?= Html::a('Create Budget', ['budget/create'], ['class' => 'btn btn-success']) ?>
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


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
