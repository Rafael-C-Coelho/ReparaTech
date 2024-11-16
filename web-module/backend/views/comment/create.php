<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Comment $model */

$this->title = 'Create Comment';
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
