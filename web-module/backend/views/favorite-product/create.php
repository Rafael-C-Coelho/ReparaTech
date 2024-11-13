<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\FavoriteProduct $model */

$this->title = 'Create Favorite Product';
$this->params['breadcrumbs'][] = ['label' => 'Favorite Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favorite-product-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
