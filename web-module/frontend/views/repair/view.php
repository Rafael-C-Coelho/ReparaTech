<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Repair $model */

$this->title = "Repair #" . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                    'label' => 'Invoice', // Rótulo exibido
                    'format' => 'raw', // Permite HTML no valor do campo
                    'value' => function ($model) {
                        return Html::a('Invoice', ['repair/download-invoice', 'id' => $model->invoice_id], [
                            'class' => 'btn btn-warning',
                            'title' => 'Download Invoice',
                            'download' => true
                        ]);
                    },
                ],
            ]]
        )?>

    </div>


    <a href="<?= \yii\helpers\Url::to(['repair/index']) ?>" type="button" style="background-color: #FFD333;"  class="btn btn-primary">
        <strong>Back</strong>
    </a>




</div>