<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\FavoriteProduct $model */

$this->title = 'Update Favorite Product: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Favorite Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="favorite-product-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
