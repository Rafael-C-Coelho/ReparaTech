<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Comment $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comment-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'repair_id',
            'description',
            'date',
            'time',
        ],
    ]) ?>

</div>
