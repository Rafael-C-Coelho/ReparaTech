<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Order $model */

$this->title = "Booking #" . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="repair-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'repair_id',
            'date',
            'time',
            'status',
        ],
    ]) ?>

</div>
