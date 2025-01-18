<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Repair $model */

$this->title = "Repair #" . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Get the latest pending budget
$pendingBudget = null;
foreach ($model->budgets->orderBy(['id' => SORT_DESC]) as $budget) {
    if ($budget->status === \common\models\Budget::STATUS_PENDING) {
        $pendingBudget = $budget;
        break;
    }
}
?>

<div class="repair">
    <div class="repair-view">
        <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'device',
                    'progress',
                    'description',
                    [
                        'label' => 'Invoice',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->invoice_id) {
                                return Html::a('Invoice', ['repair/download-invoice', 'id' => $model->invoice_id], [
                                    'class' => 'btn btn-warning',
                                    'title' => 'Download Invoice',
                                    'download' => true
                                ]);
                            }
                            return 'No invoice available';
                        },
                    ],
                ]]
        )?>

        <?php if ($pendingBudget !== null && Yii::$app->user->identity->hasRole('client')): ?>
            <div class="budget-details" style="margin-top: 20px;">
                <h3>Pending Budget Details</h3>
                <?= DetailView::widget([
                    'model' => $pendingBudget,
                    'attributes' => [
                        'value:currency',
                        'date',
                        'time',
                        'description',
                        'hours_estimated_working',
                        [
                            'label' => 'Total Labor Cost',
                            'value' => function($model) {
                                return Yii::$app->formatter->asCurrency($model->hours_estimated_working * $model->repairman->value);
                            }
                        ],
                        [
                            'label' => 'Total Cost',
                            'value' => function($model) {
                                return Yii::$app->formatter->asCurrency($model->value + ($model->hours_estimated_working * $model->repairman->value));
                            }
                        ],
                    ],
                ]) ?>

                <div class="budget-actions" style="margin-top: 20px;">
                    <?= Html::a('Accept Budget', ['repair/accept-budget', 'id' => $model->id, 'budget_id' => $pendingBudget->id], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => 'Are you sure you want to accept this budget?',
                            'method' => 'post',
                        ],
                    ]) ?>

                    <?= Html::a('Reject Budget', ['repair/reject-budget', 'id' => $model->id, 'budget_id' => $pendingBudget->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to reject this budget?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div style="margin-top: 20px;">
        <?= Html::a('<strong>Back</strong>', ['repair/index'], [
            'class' => 'btn btn-primary',
            'style' => 'background-color: #FFD333;'
        ]) ?>
    </div>
</div>