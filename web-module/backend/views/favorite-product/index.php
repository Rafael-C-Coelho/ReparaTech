<?php

use common\models\FavoriteProduct;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Favorite Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favorite-product-index">
    <p>
        <?= Html::a('Create Favorite Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'user_id',
            [
                'class' => ActionColumn::className(),
                'template'=> '{view} {update}',
                'urlCreator' => function ($action, FavoriteProduct $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
