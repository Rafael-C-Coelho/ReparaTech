<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Comment $model */

$this->title = 'Update Comment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comment-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
